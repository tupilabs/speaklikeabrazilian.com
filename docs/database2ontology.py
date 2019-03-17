from orm import DefinitionRepository, ExpressionRepository, init_db, LanguageRepository
from urllib.parse import quote_plus
import logging
import json
import os
import shutil


db_session = None


def main():
    global db_session
    logging.basicConfig(level=logging.INFO)
    db_session = init_db('mysql://root:slbr@0.0.0.0:3306/slbr?charset=utf8')
    language_repository = LanguageRepository(db_session)
    definition_repository = DefinitionRepository(db_session)
    expression_repository = ExpressionRepository(db_session)
    languages = language_repository.get_all()
    values = []

    shutil.rmtree("dist", ignore_errors=True)
    os.mkdir("dist")

    os.makedirs("dist/expressions/0", exist_ok=True)
    with open("dist/expressions/0/index.html", "w+")as f:
        f.write("""---
layout: letter
pagination:
  enabled: true
  collection: expressions
  category: "0"
  debug: false
  sort_field: 'title'
  sort_reverse: false
permalink: "/0/"
title: "Expressions with 0-9"
---""")

    for expression_letter in range(ord("a"), ord("z")+1):
        l = chr(expression_letter)
        os.makedirs(f"dist/expressions/{l}", exist_ok=True)
        with open(f"dist/expressions/{l}/index.html", "w+")as f:
            f.write(f"""---
layout: letter
pagination:
  enabled: true
  collection: expressions
  category: {l}
  debug: false
  sort_field: 'title'
  sort_reverse: false
permalink: "/{l}/"
title: "Expressions with {l.upper()}"
---""")

    for language in languages:
        logging.info("Language %s", language.description)
        # For now we will compromise in having only English, for ease of Jekyll set-up
        if language.slug == "en":
            expressions = expression_repository.get_all()
            for expression in expressions:
                definitions = definition_repository.find_by_expression(expression.id)
                logging.info("Found %d definitions", len(definitions))
                expression_dict = {
                    "expression": expression.text,
                    "letter": expression.char,
                    "definitions": []
                }

                for definition in definitions:
                    if definition.status != '2':
                        continue
                    expression = expression_repository.find(definition.expression_id)
                    logging.info("Expression: (%s) - [%s] = [%s]", definition.status, expression.text, definition.description)

                    definition_dict = {
                        "definition": definition.description,
                        "author": definition.contributor,
                        "example": definition.example,
                        "created": definition.created_at.isoformat()
                    }
                    expression_dict["definitions"].append(definition_dict)

                # interesting... the definitions or len(definitions) is giving 1 entry even when the DB has 0
                # so we force it to be realized/eval'd here
                if expression_dict["definitions"]:
                    values.append(expression_dict)
                    url_filename = quote_plus(expression.text.lower())
                    letter = expression.char.lower()
                    os.makedirs(f"dist/_expressions/{letter}", exist_ok=True)
                    with open(f"dist/_expressions/{letter}/{url_filename}.md", "w+") as f:
                        f.write(f"""---
layout: expression
category: {letter}
title: "{expression.text}"
expression: {json.dumps(expression.text)}
permalink: "/{letter}/{url_filename}/"
definitions:
""")
                        for definition in expression_dict["definitions"]:
                            f.write(f"""  - definition: {json.dumps(definition['definition'])}
    example: {json.dumps(definition['example'])}
    created: "{definition['created']}"
    author: "{definition['author']}"
""")

                        f.write("---\n")

    # produce a JSON for inspection
    # this file already is free of private info, i.e. no user IP or e-mail
    with open("slbr.json", "w+") as f:
        json.dump(values, f, indent=4, sort_keys=True)


if __name__ == '__main__':
    try:
        main()
    finally:
        if db_session:
            db_session.remove()
