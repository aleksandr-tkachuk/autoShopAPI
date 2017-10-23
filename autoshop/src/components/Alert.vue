<template>
    <div id="alert">
        <div class="alert alert-danger" role="alert" v-bind:class="{ hidden: !msg.showAlert, visible: msg.showAlert }">
            <icon class="icon" title="fail" size=70 />
            <span>{{ msg.text }}</span>
        </div>
    </div>
</template>

<script>
    import Icon from 'vue-material-design-icons/alert-octagon.vue'
    export default {
        name: 'alert',
        components: {
            Icon
        },
        computed: {
            msg() {
                return {
                    text: this.$store.getters.mainMsg.text,
                    showAlert: this.$store.getters.mainMsg.type
                }
            }
        },
        watch: {
            msg(newVal, oldVal) {
                if(newVal.showAlert) {
                    setTimeout(() => {
                        this.$store.commit('set', {
                            type: 'mainMsg',
                            items: {
                                type: '',
                                text: newVal.text
                            }
                        })
                    }, 5000)
                }
            }
        }
    }
</script>

<style >
     #alert .visible {
            transition-duration: 0.3s;
            transition-timing-function: ease-in;
            max-height: 300px;
            overflow: hidden;
        }

     #alert .hidden {
            overflow: hidden;
            max-height: 0;
            padding: 0;
            margin: 0;
            border: none;
            transition-duration: 0.3s;
            transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
        }

        .icon {
            fill: orange;
        }

</style>
