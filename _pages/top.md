---
layout: post
title: "We are redirecting you to the expression page"
permalink: "/en/top"
nosocial: true
---

You have reached this page because you have an old link to our listing of top
expressions in Brazilian Portuguese.

We do not rank our expressions any longer. We are redirecting you to the main page
in a few seconds. Feel free to browse around and search for expressions.

<script type="text/javascript">
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
/**
 * @type {string}
 */
const expression = urlParams.get('e');
const newUrl = `${window.location.protocol}//${window.location.host}/`;
console.log(`Redirect user to ${newUrl}`);
setTimeout(() => {
  window.location = newUrl;
}, 5000);
</script>
