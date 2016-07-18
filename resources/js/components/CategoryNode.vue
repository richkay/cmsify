<script>

    export default {
        props: ['name'],

        data() {
            return {
                editMode: false
            }
        },

        computed: {
            isEditmode() {
                return this.editMode;
            }
        },

        ready() {
        },

        methods: {
            toggleEditmode(e) {
                if (this.editMode) {
                    this.$parent.updateChild(this);
                }
                this.editMode = !this.editMode;
            }
        }
    }

</script>

<template>
    <div>
        <input v-if="isEditmode" v-model="name"/>
        <a href="#" v-if="!isEditmode">{{name}}</a>
        <button @click="toggleEditmode">{{isEditmode ? 'save' : 'edit'}}</button>
    </div>
</template>