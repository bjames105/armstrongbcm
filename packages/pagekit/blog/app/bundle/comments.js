!function(t){function e(n){if(o[n])return o[n].exports;var r=o[n]={exports:{},id:n,loaded:!1};return t[n].call(r.exports,r,r.exports,e),r.loaded=!0,r.exports}var o={};return e.m=t,e.c=o,e.p="",e(0)}([function(t,e){t.exports={el:"#comments",data:function(){return _.extend({post:{},tree:{},comments:[],messages:[],count:0,replyForm:!1},window.$comments)},created:function(){this.load()},methods:{load:function(){return this.$http.get("api/blog/comment{/id}",{post:this.config.post}).then(function(t){var e=t.data;this.$set("comments",e.comments),this.$set("tree",_.groupBy(e.comments,"parent_id")),this.$set("post",e.posts[0]),this.$set("count",e.count),this.reply()})},reply:function(t){t=t||this,this.replyForm&&this.replyForm.$destroy(!0),this.replyForm=new this.$options.components.reply({data:{config:this.config,parent:t.comment&&t.comment.id||0},parent:t}).$mount().$appendTo(t.$els.reply)}},components:{comment:{name:"Comment",props:["comment"],template:"#comments-item",data:function(){return{config:this.$root.config,tree:this.$root.tree}},computed:{depth:function(){for(var t=1,e=this.$parent;e;)"Comment"===e.$options.name&&t++,e=e.$parent;return t},showReplyButton:function(){return this.config.enabled&&!this.isLeaf&&this.$root.replyForm.$parent!==this},remainder:function(){return this.isLeaf&&this.tree[this.comment.id]||[]},isLeaf:function(){return this.depth>=this.config.max_depth},permalink:function(){return"#comment-"+this.comment.id}},methods:{replyTo:function(){this.$root.reply(this)}}},reply:{template:"#comments-reply",data:function(){return{author:"",email:"",content:"",error:!1,form:!1}},computed:{user:function(){return this.config.user},login:function(){return this.$url("user/login",{redirect:window.location.href})}},methods:{save:function(){var t={parent_id:this.parent,post_id:this.config.post,content:this.content};this.user.isAuthenticated||(t.author=this.author,t.email=this.email),this.$set("error",!1),this.$resource("api/blog/comment{/id}").save({id:0},{comment:t}).then(function(t){var e=t.data;this.user.skipApproval?this.$root.load().success(function(){window.location.hash="comment-"+e.comment.id}):this.$root.messages.push(this.$trans("Thank you! Your comment needs approval before showing up.")),this.cancel()},function(){this.$set("error",this.$trans("Unable to comment. Please try again later."))})},cancel:function(){this.$root.reply()}}}}},Vue.ready(t.exports)}]);