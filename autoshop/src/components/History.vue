<template>
    <div id="history" v-if="history.length">
            <b-table class="table table-striped table-hover" :items="history" :fields="fields"></b-table>
    </div>
</template>

<script>
    import axios from 'axios';
    import _ from 'lodash';

    export default {
        name: 'history',
        data() {
            return {
                fields: ['autoModel', 'autoBrand', 'userName', 'date']
            }
        },
        computed: {
            history() {
                return this.$store.getters.history
            }
        }
    }
</script>

<style>
    #history {
        border-radius: 10px;
        border: 2px solid darkgray;
        .table thead th {
            &:first-child {
                border-top: none;
            }
            &:last-child {
                border-top: none;
            }
        }
    }
</style>
