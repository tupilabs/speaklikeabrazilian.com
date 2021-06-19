---
layout: post
title: "New Expression"
date: 2021-05-29
author: "Bruno P. Kinoshita"
permalink: "/new_expression"
nosocial: true
scripts:
  - assets/js/vue.min.js
  - assets/js/new_expression_app.js
---

<p>Use the form below to create a new expression. You can then paste the YAML generated into a
<a href="https://github.com/tupilabs/speaklikeabrazilian.com/issues">GitHub issue</a>
or <a href="https://github.com/tupilabs/speaklikeabrazilian.com/compare">pull request</a>.
Once your issue is closed, or your pull request merged, your expression should appear in a few minutes.</p>

{% raw %}
<div id="app">
  
  {{ message }}
</div>
{% endraw %}
