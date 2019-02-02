from orm import DefinitionRepository, init_db, LanguageRepository
import logging


db_session = None


def main():
    global db_session
    logging.basicConfig(level=logging.INFO)
    db_session = init_db('mysql://root:slbr@0.0.0.0:3306/slbr')
    language_repository = LanguageRepository(db_session)
    definition_repository = DefinitionRepository(db_session)
    languages = language_repository.get_all()
    for language in languages:
        logging.info("Language %s", language.description)
        definitions = definition_repository.find_by_language(language.id)
        logging.info("Found %d definitions", len(definitions))


if __name__ == '__main__':
    try:
        main()
    finally:
        if db_session:
            db_session.remove()
