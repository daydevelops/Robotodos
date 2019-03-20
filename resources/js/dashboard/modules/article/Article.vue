<template>
	<div>
		<div class="row">
			<vue-table :title="$t('page.articles')" :fields="fields" api-url="article" :item-actions="itemActions" @table-action="tableActions" show-paginate>
				<template slot="buttons">
					<router-link :to="{ name: 'dashboard.article.create' }" class="btn btn-sm btn-success" v-if="checkPermission('CREATE_ARTICLE')">{{ $t('page.create') }}</router-link>
				</template>
			</vue-table>
		</div>
		<div class="modal" tabindex="-1" role="dialog" id="notify-modal">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Notify subscribers of article <span v-text="this.notifying"></span>?</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-success" data-dismiss="modal" @click="notify_test">TEST</button>
						<button type="button" class="btn btn-primary" data-dismiss="modal" @click="notify">YES</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	data() {
		return {
			fields: [{
				name: 'id',
				trans: 'table.id',
				titleClass: 'width-5-percent text-center',
				dataClass: 'text-center'
			}, {
				name: 'title',
				trans: 'table.title',
				sortField: 'title',
			}, {
				name: 'subtitle',
				trans: 'table.subtitle',
				titleClass: 'width-20-percent',
				sortField: 'subtitle',
			}, {
				name: 'published_at',
				trans: 'table.published_at',
				titleClass: 'width-10-percent',
				sortField: 'created_at'
			}, {
				name: '__actions',
				trans: 'table.action',
				titleClass: 'text-center width-20-percent',
				dataClass: 'text-center',
			}
		],
		itemActions: [
			{ name: 'notify-item', icon: 'far fa-bell', class: 'btn btn-warning' },
			{ name: 'view-item', icon: 'fas fa-eye', class: 'btn btn-success' },
			{ name: 'edit-item', permission: 'UPDATE_ARTICLE', icon: 'fas fa-pencil-alt', class: 'btn btn-info' },
			{ name: 'delete-item', permission: 'DESTROY_ARTICLE', icon: 'fas fa-trash-alt', class: 'btn btn-danger' }
		],
		notifying: 0
	}

},
methods: {
	tableActions(action, data) {
		if (action == 'edit-item') {
			this.$router.push({ name: 'dashboard.article.edit', params: { id: data.id } })
		} else if (action == 'delete-item') {
			this.$http.delete('article/' + data.id)
			.then((response) => {
				toastr.success('You delete the article success!')

				this.$emit('reload')
			}).catch(({ response }) => {
				if ((typeof response.data.error !== 'string') && response.data.error) {
					toastr.error(response.data.error.message)
				} else {
					toastr.error(response.status + ' : Resource ' + response.statusText)
				}
			})
		} else if (action == 'view-item') {
			window.open('/' + data.slug, '_blank');
		} else if (action=='notify-item') {
			this.notifying = data.id;
			$('#notify-modal').modal('show');
		}
	},
	notify() {
		$('#notify-modal').modal('show');
		this.$http.post('/article/notify/'+this.notifying)
		.then(
			(response) => {
				toastr.success('Subscribers have been notified!')
			},
			(error) => {
				console.log(error);
			}
		)
	},
	notify_test() {
		$('#notify-modal').modal('show');
		this.$http.post('/article/notifyTest/'+this.notifying)
		.then(
			(response) => {
				toastr.success('You have been notified!')
			},
			(error) => {
				console.log(error);
			}
		)
	}
}
}
</script>
