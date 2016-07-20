export default {

    data() {
        return {
            model: {},
            errors: {}
        }
    },

    methods: {

        save() {

            var endpoint = this.getEndpoint();

            if(this.model.id) {
                var method = 'put';
                endpoint += '/' + this.model.id;
            } else {
                var method = 'post';
            }

            this.$http[method](endpoint, this.model).then(r => {
                this.afterSave(r)
            }).catch((r) => {
                this.errors = r.data;
            });


        },

        afterSave(r)
        {
            this.model = r.data;
        },

        setState(state) {
            this.model.state = state;
        },

        draftState() {
            this.model.state = 'draft';
        },


    }

}