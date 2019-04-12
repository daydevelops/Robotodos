<template>
	<div>
		<div id='articles-list'>
			<draggable v-model="articles" @start="drag=true" @end="drag=false">
				<div class='row' v-for="art in articles" :key="art.id">
					<div class='col-10'>
						<p class="article">{{art.title}}</p>
					</div>
					<div class='col-2'>
						<button @click="deleteArticle(art.id)" class='btn btn-danger'>Remove</button>
					</div>
				</div>
			</draggable>
		</div>
		<div id='new-article-wrap' v-if="articles_available.length>0">
			<select id='new-art-select' class="form-control form-control-lg">
				<option class='add-art-option' value="0">None</option>
				<option v-for="art in articles_available" :key="art.id" :id='"option-"+art.id' class="add-art-option" :value="art.id" v-text="art.title"></option>
			</select>
			<button @click="addArticle()" class='btn btn-primary'>Add</button>
		</div>
		<div>
			<button class='btn btn-success' @click="updateSeries">update</button>
		</div>
	</div>
</template>

<script>
import draggable from 'vuedraggable'
export default {
	components: {
		draggable,
	},
	data() {
		return {
			series: undefined,
			articles:[],
			articles_available:[],
		}
	},
	created() {
		this.$http.get('series/edit/' + this.$route.params.id)
		.then((response) => {
			this.series = response.data.series;
			this.articles = this.series.articles;
			// debugger
			this.articles_available = response.data.articles_available;
		})
	},
	methods: {
		addArticle() {
			var article_id = $('#new-art-select').val();
			if (article_id == 0) {
				return;
			}
			var article;
			this.articles_available.forEach(function(art,ind) {
				if (art.id == article_id) {
					article = art;
					return;
				}
			});
			this.articles.push(article);
			$('#option-'+article_id).css('display','none');
			$('#new-art-select').val(0);
		},
		deleteArticle(id) {
			var index_to_remove;
			this.articles.forEach(function(art,ind) {
				if (art.id == id) {
					index_to_remove = ind;
					return;
				}
			});
			this.articles.splice(index_to_remove,1);
		},
		updateSeries() {
			let new_articles = this.articles.map(({ id }) => id);
			console.log()
			this.$http.patch('series/order/' + this.$route.params.id, {articles:new_articles})
			.then((response) => {
				// location.reload();
			})
		}

	}
}
</script>
<style>
#articles-list {
	width:80%;
	margin:auto;
}
#articles-list .article {
	border:1px solid black;
	margin:10px 0px;
	width:100%;
	padding:10px;
	font-size:18px;
	border-radius:10px;
}


</style>
