from sqlalchemy import Column, DateTime, String, Integer, CHAR, create_engine
from sqlalchemy.ext.declarative import declarative_base,declared_attr
from sqlalchemy.orm import scoped_session, sessionmaker, Query


class Base(object):
    @declared_attr
    def __tablename__(cls):
        return cls.__name__.lower()

    __table_args__ = {'mysql_engine': 'InnoDB'}

    id =  Column(Integer, primary_key=True)

    def dump(self):
        return dict(
            [(k, v) for k, v in vars(self).items() if not k.startswith('_')])


Base = declarative_base(cls=Base)


class Languages(Base):
    id = Column(Integer(), primary_key=True)
    slug = Column(String())
    description = Column(String())
    local_description = Column(String())
    created_at = Column(DateTime())
    updated_at = Column(DateTime())


class LanguageRepository(object):

    def __init__(self, session):
        self._session = session

    def get_all(self):
        q = self._session.query(Languages)  # type: Query
        return q.all()


class Expressions(Base):
    id = Column(Integer(), primary_key=True)
    text = Column(String())
    char = Column(CHAR())
    contributor = Column(String())
    created_at = Column(DateTime())
    updated_at = Column(DateTime())


class ExpressionRepository(object):

    def __init__(self, session):
        self._session = session

    def get_all(self):
        q = self._session.query(Expressions)  # type: Query
        return q.all()


def init_db(uri):
    engine = create_engine(uri, convert_unicode=True)
    db_session = scoped_session(
        sessionmaker(autocommit=False, autoflush=False, bind=engine))
    Base.query = db_session.query_property()
    Base.metadata.create_all(bind=engine)
    return db_session
