<template>
    <div id="root">
        <div class="form-group">
            <div class="alert alert-danger" v-if="error">
                <strong>Error</strong> {{error}}
            </div>
            <div class="alert alert-success" v-if="success">
                <strong>Success</strong> {{success}}
            </div>
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
            <small>{{ comment.created_at }}</small>
            <div class="container">
                <div class="row">
                    <div class="col">
                        {{ comment.text}}
                    </div>
                    <div class="col-md-auto">
                        <button class="btn btn-primary pull-right" id="editButton" v-if="comment.user.id == userId" @click="editCommentButton(comment)">Edit</button>
                        <button class="btn btn-danger pull-right" v-if="comment.user.id == userId" @click="deleteComment(comment)">Delete</button>
                        <button class="btn btn-danger pull-right" v-else-if="userType == admin" @click="deleteComment(comment)">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="application/javascript">
    export default {
        props: ['postId', 'userId', 'userType'],
        data() {
            return {
                comments: [],
                error: '',
                success: '',
                admin: 'admin',
                newComment: '',
                commentMessage: 'Post a comment',
                changeOrPost: 'Post',
                commentIdBeingEdited: Object
            }
        },
        mounted() {
            this.fetchComments();
        },
        methods: {
            fetchComments: function() {
                axios.get("/comments/" + this.postId)
                .then(response => {
                    //success
                    console.log(response.data);
                    this.comments = response.data;
                    this.newComment = '';
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
            deleteComment: function (comment) {
                 axios.delete("/comment/" + comment.id + "/" + this.postId)
                .then(response => {
                    //success
                    this.fetchComments();
                    this.success = response.message;
                })
                .catch(error => {
                    //failure
                    this.error = error.response.data.error;
                })
            },
            postComment: function () {
                axios.post("/comments", {
                    text: this.newComment,
                    post_id: this.postId,
                    user_id: this.userId
                })
                .then(response => {
                    //success
                    this.comments.unshift(response.data);
                    this.newComment = '';
                    this.error = '';
                })
                .catch(error => {
                    //failure
                    this.error = error.response.data.error;
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
                    this.fetchComments();
                    this.commentMessage = "Post a comment";
                    this.changeOrPost = "Post";
                    this.commentIdBeingEdited = null;
                    this.error = '';
                })
                .catch(error => {
                    //failure
                    this.error = error.response.data.error;
                })
            }
        }
    };
</script>