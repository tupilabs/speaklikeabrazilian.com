<template>
    <footer>
        <b-container>Speak Like A Brazilian &copy; 2010-{{ new Date().getFullYear() }}</b-container>
    </footer>
</template>

<script>
    export default {
        name: "Footer"
    }
</script>

<style>
    html {
        position: relative;
        min-height: 100%;
    }
    body {
        /* Margin bottom by footer height */
        margin-bottom: 60px;
    }
    footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        /* Set the fixed height of the footer here */
        height: 60px;
        line-height: 60px; /* Vertically center the text there */
        background-color: #f5f5f5;
    }
</style>
