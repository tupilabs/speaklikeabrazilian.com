# speaklikeabrazilian.com

A website with Brazilian Portuguese expressions. Content licensed under the
[Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International Public License](LICENSE.txt).

## Expressions format

Expressions are create as Markdown files, using Jekyll's [Front Matter](https://jekyllrb.com/docs/front-matter/)
YAML metadata. This is the current schema of an expression Markdown file.

```yaml
---
layout: expression
category: a # This is the letter collection name, values are a-z, and 0 for numerical 
title: "A gente chamando siri de meu bife" # This is the page title
expression: "A gente chamando siri de meu bife" # This is the expression display name
permalink: "/a/a+gente+chamando+siri+de+meu+bife/" # This is the expression permanent link
synonyms:
  - urubu em guerra é frango
variations:
  - no aperto siri é bife
alternate_spellings: # An array of other (mis)spellings for this expression
  - agente chamando siri de meu bife
definitions: # An array of definitions for this expression
  - definition: | # Definition value, here is a multi-line YAML entry
      Its translation would be "We calling crab of my steak". It is used when you are in a situation
      where you are struggling, especially financially. In which case, you would consider a crab as
      good as an expensive steak.
    example: | # Examples of the expression in Portuguese (title and here are only places where PT-BR is used)
      - Ofereceram até a mala branca.
      - Se vocês ganharem do Flamengo tem um bichinho por fora...
      - **A gente chamando siri de meu bife**, uma fase ruim....
    created: "2020-04-18T18:56:00" # Date of the creation of the entry
    author: "kinow" # Author nickname
    videos: # An array of videos for this expression
      - title: Soccer program "Boleiragem", where Zé do Carmo uses this expression # Video display name
        link: https://youtu.be/S1H4Y8alLmo?t=1269 # Video link (in this case the link has the time parameter)
---

```

## Build

```bash
$ bundle install
$ bundle exec jekyll serve -w --incremental
```

## Deploy

Pushing to GitHub is the only requirement to update the site.

To update the search index, it needs a command similar to the following example:

```bash
$ bundle exec jekyll build && ghp-import -p -r origin -b gh-pages _site/ && ALGOLIA_API_KEY=$ALGOLIA_KEY bundle exec jekyll algolia
```
