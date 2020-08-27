<script>
import Favorite from './Favorite.vue';

export default {
    props: ['attributes'],

    components: {Favorite},
    
    data() {
        return {
            editing: false,
            body: this.attributes.body
        };
    },
    methods: {
        update() {
            axios.patch('/forum/public/replies/' + this.attributes.id, {
                body: this.body
            });
            this.editing = false;
            flash('Updated!');
        },
        destroy() {
            axios.delete('/forum/public/replies/' + this.attributes.id);
            $(this.$el).fadeOut(500, () => {
                flash('Your reply has been deleted.');
            });
        }
    }
}
</script>
