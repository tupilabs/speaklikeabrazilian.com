---
layout: post
title: "We are redirecting you to the expression page"
permalink: "/expression/define"
---

You have reached this page because you have an old link to one of our Brazilian
Portuguese expressions.

We changed the URL pattern for expression some time ago. Our expressions used to have
URL's such as **"/expression/define?e=gambiarra"**, but now the same expression should
be available under **"/g/gambiarra"**.

This page should automatically redirect you in a couple seconds if you have
JavaScript enabled. Otherwise, just try our search box above, or try changing
the URL using the first letter (or '0 zero if the expression starts with
a number), and the expression in the URL address bar.

<script type="text/javascript">
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
/**
 * @type {string}
 */
const expression = urlParams.get('e');
if (expression && expression.trim() !== '') {
  let firstLetter = expression[0];
  if (!isNaN(firstLetter)) {
    firstLetter = '0'
  }
  const newUrl = `${window.location.protocol}//${window.location.host}/${firstLetter}/${expression}`;
  console.log(`Redirect user to ${newUrl}`);
  setTimeout(() => {
    window.location = newUrl;
  }, 2000);
}
</script>
