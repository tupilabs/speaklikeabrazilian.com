from pathlib import Path, PosixPath
import re
from typing import Generator


def expression_exists(expressions_folder, expression) -> bool:
	return Path("").exists()


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
