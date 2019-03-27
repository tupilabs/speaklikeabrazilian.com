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
	return f"{expression}"


def walk_expressions_path(expressions_path: Path) -> Generator[PosixPath, None, None]:
	for file in expressions_path.glob("**/*.md"):
		yield file


def get_expressions_folder() -> Path:
	return Path("../_expressions")


def main():
	expressions_path = get_expressions_folder()
	for path in walk_expressions_path(expressions_path):
		with open(path.absolute(), 'r+') as expressions_file:
			text = expressions_file.readlines()
			content = []
			for line in text:
				links = re.findall(r'\[([^\]]*)\][^\(]', line)
				for link in links:
					expression_filename = get_expression_filename(link)
					letter = get_letter(link)
					expression_path = Path(f"{expressions_path}/{letter}/{expression_filename}.md")
					if expression_path.exists():
						permalink = f"/{letter}/{expression_filename}/"
						# print(f"{path.name}: We need to link [permalink]({permalink}) !")
						line = line.replace(f"[{link}]", f"[{link}]({permalink})")
					else:
						line = line.replace(f"[{link}]", f"{link}")
				content.append(line)
			expressions_file.seek(0)
			expressions_file.write("".join(content))
			expressions_file.truncate()


if __name__ == '__main__':
	main()
