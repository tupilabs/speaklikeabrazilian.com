from sqlalchemy import Column, DateTime, String, Integer, CHAR, create_engine
from sqlalchemy.ext.declarative import declarative_base, declared_attr
from sqlalchemy.orm import scoped_session, sessionmaker, Query


class Base(object):
    @declared_attr
    def __tablename__(cls):
        return cls.__name__.lower()

    __table_args__ = {'mysql_engine': 'InnoDB'}

    id = Column(Integer, primary_key=True)
    created_at = Column(DateTime())
    updated_at = Column(DateTime())

    def dump(self):
        return dict(
            [(k, v) for k, v in vars(self).items() if not k.startswith('_')])


Base = declarative_base(cls=Base)


class Languages(Base):
    slug = Column(String())
    description = Column(String())
    local_description = Column(String())


class LanguageRepository(object):

    def __init__(self, session):
        self._session = session

    def get_all(self):
        q = self._session.query(Languages)  # type: Query
        return q.all()


class Definitions(Base):
    expression_id = Column(Integer())
    description = Column(String(1000))
    example = Column(String(1000))
    tags = Column(String(100))
    status = Column(CHAR)
    email = Column(String(255))
    contributor = Column(String(50))
    user_ip = Column(String(60))
    language_id = Column(Integer())


class DefinitionRepository(object):

    def __init__(self, session):
        self._session = session

    def get_all(self):
        q = self._session.query(Definitions)  # type: Query
        return q.all()

    def find_by_language(self, language_id):
        q = self._session.query(Definitions)  # type: Query
        q = q.filter(Definitions.language_id == language_id)
        return q.all()


class Expressions(Base):
    text = Column(String())
    char = Column(CHAR())
    contributor = Column(String())


class ExpressionRepository(object):

    def __init__(self, session):
        self._session = session

    def get_all(self):
        q = self._session.query(Expressions)  # type: Query
        return q.all()

    def find(self, expression_id):
        q = self._session.query(Expressions)  # type: Query
        q = q.filter(Expressions.id == expression_id)
        return q.one_or_none()


def init_db(uri):
    engine = create_engine(uri, convert_unicode=True)
    db_session = scoped_session(
        sessionmaker(autocommit=False, autoflush=False, bind=engine))
    Base.query = db_session.query_property()
    Base.metadata.create_all(bind=engine)
    return db_session
