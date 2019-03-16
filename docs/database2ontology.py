from orm import DefinitionRepository, ExpressionRepository, init_db, LanguageRepository
import logging
import json


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
    for language in languages:
        logging.info("Language %s", language.description)
        definitions = definition_repository.find_by_language(language.id)
        logging.info("Found %d definitions", len(definitions))
        for definition in definitions:
            if definition.status != '2':
                continue
            expression = expression_repository.find(definition.expression_id)
            logging.info("Expression: (%s) - [%s] = [%s]", definition.status, expression.text, definition.description)

            values.append({
                "language": language.slug,
                "expression": expression.text,
                "definition": definition.description,
                "example": definition.example
            })

    with open("slbr.json", "w+") as f:
        json.dump(values, f, indent=4, sort_keys=True)


if __name__ == '__main__':
    try:
        main()
    finally:
        if db_session:
            db_session.remove()
