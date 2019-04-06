<template>
	<form @submit.prevent="onSubmit">
		<div class="form-group">
			<div class="row">
				<label for="name" class="col-sm-2 col-form-label">Name</label>
				<div class="col-sm-6">
					<input type="text" id="name" name="name" v-model="name" class="form-control">
				</div>
				<div class="col-sm-3">
					<button type="submit" class="btn btn-success form-control">Add</button>
				</div>
			</div>
		</div>
	</form>
</template>

<script>

export default {
	data () {
		return {
			name:""
		}
	},
	methods: {
		onSubmit() {
			this.$http.post('series/new',{name:this.name})
	          .then((response) => {
	            toastr.success('You created the new category!')

	            this.$emit('reload')
	          }).catch(({ response }) => {
	            toastr.error(response.status + ' : Resource ' + response.statusText)
	          })
		}
	}
}
</script>
