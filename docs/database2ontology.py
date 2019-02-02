from orm import ExpressionRepository, Expression, init_db
import logging


db_session = None


def main():
    global db_session
    logging.basicConfig(level=logging.INFO)
    db_session = init_db('mysql://root:slbr@0.0.0.0:3306/slbr')
    expression_repository = ExpressionRepository(db_session)
    print([expression.dump() for expression in expression_repository.get_all()])


if __name__ == '__main__':
    try:
        main()
    finally:
        if db_session:
            db_session.remove()
