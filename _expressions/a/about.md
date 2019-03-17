---
layout: default
category: a
expression: Abraço de urso
definitions:
  - definition: "A super tight hug, that you give to someone you've been missing, or to someone that you simply love."
    example: "- Oh, que beb\u00ea lindo. D\u00e1 vontade de esmagar! Vou dar um super abra\u00e7o de urso, pode?"
    created: "2013-05-22T15:44:54"
    author: "kinow"
  - definition: "Same as bear hug."
    example: "- Vem c\u00e1 e me d\u00e1 um abra\u00e7o de urso!"
    created: "2013-05-22T16:09:01"
    author: "kinow"
---

# {{ page.expression }}

{% for entry in page.definitions %}

{{ index }} {{ entry.definition }}

<span class="example">
_{{ entry.example }}_
</span>

{% endfor %}
