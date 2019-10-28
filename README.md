# speaklikeabrazilian.com

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
