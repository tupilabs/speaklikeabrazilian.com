---
layout: page
title: Expressions starting with A
pagination: 
  enabled: true
  collection: expressions
  category: a
---

{% for post in paginator.posts %}
  <h1>{{ post.title }}</h1>
{% endfor %}

{% if paginator.total_pages > 1 %}
<ul>
  {% if paginator.previous_page %}
  <li>
    <a href="{{ paginator.previous_page_path | prepend: site.baseurl }}">Newer</a>
  </li>
  {% endif %}
  {% if paginator.next_page %}
  <li>
    <a href="{{ paginator.next_page_path | prepend: site.baseurl }}">Older</a>
  </li>
  {% endif %}
</ul>
{% endif %}
