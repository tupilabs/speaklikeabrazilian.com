from pathlib import Path, PosixPath
import re
from typing import Generator
from urllib.parse import quote_plus, quote


LETTERS_RANGE = [chr(x) for x in range(ord('a'), ord('z')+1)]


def get_letter(expression: str) -> str:
	first_char = expression[0].lower()
	if first_char in LETTERS_RANGE:
		return first_char
	return '0'


def get_expression_filename(expression: str) -> str:
	expression = expression.encode('utf-8').decode('unicode-escape')
	expression = expression.lower().strip()
	expression = quote(expression)
	expression = expression.replace(' ', '+')
	return f"{expression}.md"


def expression_exists(expressions_path, expression, tmp_file) -> bool:
	letter = get_letter(expression)
	expression_filename = get_expression_filename(expression)
	expression_path = f"{expressions_path}/{letter}/{expression_filename}"
	if not Path(expression_path).exists():
		print(f"For [{tmp_file}] : {expression_path}")
	return Path(expression_path).exists()


def walk_expressions_path(expressions_path : Path) -> Generator[PosixPath, None, None]:
	for file in expressions_path.glob("**/*.md"):
		yield file


def get_expressions_folder() -> str:
	return Path("../_expressions")


def main():
	expressions_path = get_expressions_folder()
	# print(f"Expressions folder: {expressions_path}")
	
	for path in walk_expressions_path(expressions_path):
		# print(f"Expressions file {file}")
		with path.open() as expressions_file:
			for line in expressions_file:
				links = re.findall(r'\[([^\]]*)\][^\(]', line)
				for link in links:
					if expression_exists(expressions_path, link, path.name):
						# print(f"{path.name}: We need to link [{link}] !")
						pass


if __name__ == '__main__':
	main()
