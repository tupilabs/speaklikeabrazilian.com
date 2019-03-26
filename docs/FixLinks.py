from pathlib import Path, PosixPath
import re
from typing import Generator


LETTERS_RANGE = [chr(x) for x in range(ord('a'), ord('z')+1)]


def get_letter(expression: str) -> str:
	first_char = expression[0].lower()
	if first_char in LETTERS_RANGE:
		return first_char
	return '0'


def expression_exists(expressions_path, expression) -> bool:
	letter = get_letter(expression)
	expression_path = f"{expressions_path}/{letter}/{expression}.md".lower()
	print(expression_path)
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
					if expression_exists(expressions_path, link):
						print(f"{path.name}: We need to link [{link}] !")


if __name__ == '__main__':
	main()
