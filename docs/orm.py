from sqlalchemy import Column, DateTime, String, Integer, CHAR, create_engine
from sqlalchemy.ext.declarative import declarative_base
from sqlalchemy.orm import scoped_session, sessionmaker, Query

Base = declarative_base()


class Expression(Base):

    __tablename__ = "expressions"
    id = Column(Integer(), primary_key=True)
    text = Column(String())
    char = Column(CHAR())
    contributor = Column(String())
    created_at = Column(DateTime())
    updated_at = Column(DateTime())

    def dump(self):
        return dict(
            [(k, v) for k, v in vars(self).items() if not k.startswith('_')])


class ExpressionRepository(object):

    def __init__(self, session):
        self._session = session

    def get_all(self):
        q = self._session.query(Expression)  # type: Query
        return q.all()


def init_db(uri):
    engine = create_engine(uri, convert_unicode=True)
    db_session = scoped_session(
        sessionmaker(autocommit=False, autoflush=False, bind=engine))
    Base.query = db_session.query_property()
    Base.metadata.create_all(bind=engine)
    return db_session
