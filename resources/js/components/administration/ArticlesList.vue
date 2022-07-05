<template>
    <div class="container">
		<div class="row mt-5">
			<div class="col-sm-10 mx-auto">
				<h3>Tutti gli articoli del blog</h3>
			</div>
		</div>
		<div class="row mt-3">
			<div v-if="this.recipes.length > 10" class="row">
            <nav aria-label="Page navigation example" class="d-flex justify-content-end pagination-padding-desktop">
                <ul class="pagination">
                    <li class="page-item">
                    <a class="page-link" href="#" id="prev-page" @click.prevent="prevPage" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">&laquo;</span>
                    </a>
                    </li>
                    <li class="page-item">
                    <a class="page-link" href="#"  id="next-page" @click.prevent="nextPage" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">&raquo;</span>
                    </a>
                    </li>
                </ul>
            </nav>
        </div>
			<div class="col-sm-10 mx-auto" style="display:block;">
				<table class="table table-striped w-100" style="overflow-x:auto;white-space:nowarp">
					<thead>
						<tr class="p-2 m-2">
							<th class="p-2 m-2">ID</th>
							<th class="p-2 m-2">Date</th>
							<th class="p-2 m-2">Title</th>
							<th class="p-2 m-2">Category</th>
							<th class="p-2 m-2">Keywords</th>
							<th class="p-2 m-2 text-center">Actions</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="recipe in showRecipes" :key="recipe.id" class="p-2 m-2">
							<th class="p-2 m-2">{{ recipe.id }}</th>
							<td class="p-2 m-2">{{ moment(recipe.created_at).format('DD/MM/YYYY') }}</td>
							<td class="p-2 m-2">{{ recipe.name }}</td>
							<td class="p-2 m-2">{{ recipe.category }}</td>
							<td class="p-2 m-2">{{ recipe.keywords }}</td>
							<td class="m-2 text-center">
								<a :href="recipeLink(recipe.id)"><button class="btn btn-sm btn-success mx-2"><i class="fa-solid fa-file-lines"></i> <span class="hidden-mobile">Show</span></button></a>
								<router-link :to="{ name: 'edit', params: {recipe: recipe} }"><button class="btn btn-sm btn-warning mx-2 text-white"><i class="fa-solid fa-pencil text-white"></i> <span class="hidden-mobile">Edit</span></button></router-link>
								<button class="btn btn-sm btn-danger mx-2" @click="del(recipe.id)"><i class="fa-solid fa-trash-can"></i> <span class="hidden-mobile">Delete</span></button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</template>

<script>
import moment from 'moment';
export default {
	data(){
		return {
			recipes: [],
			showRecipes: [],
			perPage: 10,
            actPage: 1,
			moment: moment
		}
	},
	methods: {
		recipeLink(id) {
			return '/recipes/' + id
		},
		editLink(id) {
			return '/recipes/edit' + id
		},
		 async read() {
        	await axios.get('/api/recipes') .then(response => {
			response.data.forEach(element => {
			this.recipes.push(element)
			});
        });
		this.pagination();
        },
		async del(id) {
			await axios.delete(`/api/delete/recipe/${id}`);
			let index = this.showRecipes.indexOf((element) => element.id == id);
			this.showRecipes.splice(index, 1);		
		},
		nextPage() {
			this.actPage++;
			this.recipes.slice((this.actPage + this.perPage-1), (this.actPage * this.perPage));
			this.pagination();
        },
        prevPage() {
			this.actPage--;
			this.recipes.slice((this.actPage + this.perPage-1), (this.actPage * this.perPage));
			this.pagination();
    	},
    	checkLength(length) {
			if (this.recipes.length > length) return length
			else return this.recipes.length
    	},
        pagination() {
			this.showRecipes = [];
			if (this.actPage == 1) {
				for (let i=this.actPage; i<=this.checkLength((this.actPage*this.perPage)); i++) {
					this.showRecipes.push(this.recipes[i-1]);
				}
			} else {
				for (let i=(this.actPage-1)*this.perPage+1; i<=this.checkLength((this.actPage*this.perPage)); i++) {
					this.showRecipes.push(this.recipes[i-1]);
				}
			}
			if (this.recipes.length > this.perPage) {
				if (this.actPage == 1) document.getElementById('prev-page').style.visibility = 'hidden';
				else document.getElementById('prev-page').style.visibility = 'visible';
				if (this.recipes.length < (this.perPage*this.actPage)-1) document.getElementById('next-page').style.visibility = 'hidden';
				else document.getElementById('next-page').style.visibility = 'visible';
			}
        }
    },
	created() {
		this.read();
	}
}

</script>


<style scoped>
    .pagination-padding-desktop {
        padding-right:7em !important;
    }

  @media screen and (max-width: 577px) {
    .pagination-padding-desktop {
    padding-right: 0.5rem !important;
    padding-left: 0.5rem !important;
    }
	.hidden-mobile {
		display:none;
	}
  }
</style>