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

            if (this.model.id) {
                var method = 'put';
                endpoint += '/' + this.model.id;
            } else {
                var method = 'post';
            }

            this.$http[method](endpoint, this.model).then(r => {
                this.afterSave(r)
                if (r.data.state == 'published') {
                    toastr.success('Post Published!');
                } else {
                    toastr.info('Post Saved!');
                }
            }).catch((r) => {
                this.errors = r.data;
                toastr.error('Post couldnt Saved...');
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