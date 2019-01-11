<template>
    <b-navbar toggleable="md" type="dark" variant="info" fixed="top" sticky>

        <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>

        <b-collapse is-nav id="nav_collapse">

            <b-navbar-nav class="mr-auto">
                <b-nav-item href="#">Home</b-nav-item>
                <b-nav-item href="#">FaceBook</b-nav-item>
                <b-nav-item href="#">Twitter</b-nav-item>
            </b-navbar-nav>

            <b-navbar-brand href="#" class="mx-auto">Speak Like A Brazilian</b-navbar-brand>

            <!-- Right aligned nav items -->
            <b-navbar-nav class="ml-auto">

                <b-nav-form>
                    <b-form-input size="sm" class="mr-sm-2" type="text" placeholder="Search"/>
                    <b-button size="sm" class="my-2 my-sm-0" type="submit">Search</b-button>
                </b-nav-form>

                <b-nav-item-dropdown text="EN" right>
                    <b-dropdown-item href="#">EN</b-dropdown-item>
                    <b-dropdown-item href="#">DE</b-dropdown-item>
                    <b-dropdown-item href="#">ES</b-dropdown-item>
                    <b-dropdown-item href="#">IT</b-dropdown-item>
                    <b-dropdown-item href="#">JP</b-dropdown-item>
                </b-nav-item-dropdown>
            </b-navbar-nav>

        </b-collapse>
    </b-navbar>
</template>

<script>
    export default {
        name: "Nav"
    }
</script>

<style scoped>

</style>
