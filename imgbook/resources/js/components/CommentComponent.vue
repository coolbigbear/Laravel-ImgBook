<template>
    <div id="root">
        {{ commentMessage}}
        
        <input type="text" id="input" v-model="newComment">
        <button @click="createComment">{{changeOrPost}}</button>

        Comments:
        <ul>
            <li v-for="comment in comments" :key="comment.id">
                {{ comment.user.username }} -- {{ comment.text}}
                <button id="editButton" v-if="comment.user.id == userId" @click="editCommentButton(comment)">Edit</button>
            </li>
        </ul>
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