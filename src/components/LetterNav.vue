<template>
    <b-navbar toggleable="md" type="dark" variant="info" fixed="top" sticky>

        <b-navbar-toggle target="nav_collapse_letters"></b-navbar-toggle>

        <b-collapse is-nav id="nav_collapse_letters">

            <b-navbar-nav>
                <b-nav-item v-for="letter in letters" :key="letter" href="#">{{ letter }}</b-nav-item>
            </b-navbar-nav>

        </b-collapse>
    </b-navbar>
</template>

<script>
    export default {
        name: "LetterNav",
        data: function() {
            return {
                letters: "0ABCDEFGHIJKLMNOPQRSTUVWXYZ#".split("")
            }
        }
    }
</script>

<style scoped>

</style>
