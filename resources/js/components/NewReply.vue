<template>
    <div>
        <div class="mt-5" v-if="signedIn">
            <div class="form-group">
                <textarea   name="body"
                            id="body"
                            class="form-control"
                            rows="5"
                            required
                            placeholder="Have something to say?"
                            v-model="body">
                </textarea>
            </div>

            <button type="submit"
                    class="btn btn-primary"
                    @click="addReply">Post
            </button>
        </div>

     <p class="text-center mt-5" v-else>Please
            <a href="/login">sign in</a> to participate in this discussion!</p>


    </div>
</template>

<script>
export default {

    data() {
        return {
            body: ''
        };
    },

    computed: {
        signedIn() {
            return window.App.signedIn;
        }
    },

    methods: {
        addReply() {
            axios.post(location.pathname + '/replies',{ body: this.body})
                .then (response => {
                    this.body='';

                    flash('Your reply has been posted.');

                    this.$emit( 'created', response.data);
                });
        }

    }

}
</script>
