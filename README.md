# speaklikeabrazilian.com

![Build and deploy site to GitHub Pages](https://github.com/tupilabs/speaklikeabrazilian.com/workflows/Build%20and%20deploy%20site%20to%20GitHub%20Pages/badge.svg)
[![License: CC BY-NC-ND 4.0](https://img.shields.io/badge/License-CC%20BY--NC--ND%204.0-lightgrey.svg)](https://creativecommons.org/licenses/by-nc-nd/4.0/)
[![Website](https://img.shields.io/website/https/speaklikeabrazilian.com.svg?color=green&up_message=live)](https://speaklikeabrazilian.com/)

A website with Brazilian Portuguese expressions. Content licensed under the
[Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International Public License](LICENSE.txt).

## Expressions format

Expressions are created as Markdown files, using Jekyll's [Front Matter](https://jekyllrb.com/docs/front-matter/)
YAML metadata. This is the current schema of an expression Markdown file.

```yaml
---
layout: expression
category: a # This is the letter collection name, values are a-z, and 0 for numerical 
title: "A gente chamando siri de meu bife" # This is the expression and page title
permalink: "/a/a+gente+chamando+siri+de+meu+bife/" # This is the expression permanent link
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
    synonyms:
      - urubu em guerra é frango
    created: "2020-04-18T18:56:00" # Date of the creation of the entry
    author: "kinow" # Author nickname
    images: # An array of images for this expression
      - urubu1.gif # This file must exist at /assets/images/expressions/{expression.permalink}/urubu1.gif
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

Pushing to GitHub is the only requirement to update the site. We have a GitHub action that publishes
the site when a commit is pushed to the `master` branch. It also takes care to update the Algolia
search index.

To update the search index locally, the following example command can be used:

```bash
$ bundle exec jekyll build && ghp-import -p -r origin -b gh-pages _site/ && ALGOLIA_API_KEY=$ALGOLIA_KEY bundle exec jekyll algolia
```
