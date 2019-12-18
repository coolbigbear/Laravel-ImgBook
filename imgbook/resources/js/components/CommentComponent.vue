<template>
    <div id="root">
        <div class="form-group">
            <label><b>{{ commentMessage }}</b></label>
            <div class="input-group">
                <input type="textarea" name="text" class="form-control" placeholder="Enter a comment" v-model="newComment">
                <div>&nbsp;</div> <!-- add single space -->
                <button class="btn btn-primary" @click="createComment">{{changeOrPost}}</button>
            </div>
        </div>
        <hr/>
        <div v-for="comment in comments" :key="comment.id">
            <h4 class="media-heading user_name">{{ comment.user.username }}</h4>
            <p><small>{{ comment.updated_at }}</small></p>
            <div class="container">
                <div class="row">
                    <div class="col">
                        {{ comment.text}}
                    </div>
                    <div class="col-md-auto">
                        <button class="btn btn-primary pull-right" id="editButton" v-if="comment.user.id == userId" @click="editCommentButton(comment)">Edit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="application/javascript">
    export default {
        props: ['postId', 'userId'],
        data() {
            return {
                comments: [],
                newComment: '',
                commentMessage: 'Post a comment',
                changeOrPost: 'Post',
                commentIdBeingEdited: Object
            }
        },
        mounted() {
            this.fetchComments()
        },
        methods: {
            fetchComments: function() {
                axios.get("/comments/" + this.postId)
                .then(response => {
                    //success
                    this.comments = response.data;
                    this.newComment = '';
                    console.log(response.data);
                })
                .catch(response => {
                    //failure
                    console.log(response);
                })
            },
            createComment: function () {
                if(this.changeOrPost == "Post") {
                    this.postComment();
                } else {
                    this.putComment();
                }
            },
            postComment: function () {
                axios.post("/comments", {
                    text: this.newComment,
                    post_id: this.postId,
                    user_id: this.userId
                })
                .then(response => {
                    //success
                    this.comments.push(response.data);
                    this.newComment = '';
                })
                .catch(response => {
                    //failure
                    console.log(response);
                })
            },
            editCommentButton: function (comment) {
                this.commentMessage = "Editing comment"
                this.changeOrPost = "Change"
                this.newComment = comment.text;
                this.commentIdBeingEdited = comment;
            },
            putComment: function () {
                axios.put("/comments/" + this.commentIdBeingEdited.id, {
                    text: this.newComment
                })
                .then(response => {
                    //success
                    this.comments.push(response.data);
                    this.commentMessage = "Post a comment";
                    this.changeOrPost = "Post";
                    this.commentIdBeingEdited = null;
                    this.fetchComments();
                })
                .catch(response => {
                    //failure
                    console.log(response);
                })
            }
        }
    };
</script>