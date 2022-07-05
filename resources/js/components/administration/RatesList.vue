<template>
    <div class="container">
		<div class="row mt-5">
			<div class="col-sm-10 mx-auto">
				<h3>Valutazioni lasciate dagli utenti</h3>
			</div>
		</div>
		<div class="row mt-3">
			<div v-if="this.rates.length > this.perPage" class="row">
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
        </div>
		<div class="row mt-4">
			<div class="col-sm-10 mx-auto">
				<table class="table table-striped w-100" style="overflow-x:auto;white-space:nowarp;display:block;">
					<thead>
						<tr class="p-2 m-2">
							<th class="p-2 px-4 m-2">ID</th>
							<th class="p-2 px-4 m-2">Date</th>
							<th class="p-2 px-4 m-2">Recipe</th>
							<th class="p-2 px-4 m-2">Text</th>
							<th class="p-2 px-4 m-2">Rate</th>
							<th class="p-2 px-4 m-2">User</th>
							<th class="p-2 px-4 m-2 text-center">Actions</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="rate in showRates" :key="rate.id" class="p-2 m-2">
							<th class="p-2 px-4 m-2">{{ rate.id }}</th>
							<td class="p-2 px-4 m-2">{{ moment(rate.created_at).format('DD/MM/YYYY') }}</td>
							<td class="p-2 m-2 fw-bold">{{ returnRecipeName(rate.recipe_id) }}</td>
							<td class="p-2 m-2">{{ rate.comment }}</td>
							<td class="p-2 m-2 text-center">{{ rate.rate_id }}</td>
							<td class="p-2 px-4 m-2">{{ returnUserName(rate.user_id) }}</td>
							<td class="m-2 text-center">
								<button class="btn btn-sm btn-danger mx-2" @click="del(rate.id)">Delete</button>
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
			rates: [],
			showRates: [],
			recipes: [],
			users: [],
			perPage: 10,
			actPage: 1,
			moment: moment
		}
	},
	methods: {
		 async read() {
          await axios.get('/api/allrates/all') .then(response => {
            response.data.forEach(element => {
              this.rates.push(element)
            });
          });
		  this.pagination();
        },
		async readUsers() {
          await axios.get('/api/users') .then(response => {
            response.data.forEach(element => {
              this.users.push(element)
            });
          });
        },
		async readRecipes() {
          await axios.get('/api/recipes') .then(response => {
            response.data.forEach(element => {
              this.recipes.push(element)
            });
          });
        },
		async del(id) {
			await axios.delete(`/api/rates/del/${id}`);
			let index = this.showRates.findIndex((element) => element.id == id);
			this.showRates.splice(index, 1);
			this.pagination();
		},
		returnRecipeName(id) {
            for (let i = 0; i < this.recipes.length; i++) {
                if (this.recipes[i].id == id) {
                    return this.recipes[i].name;
                }
            }
        },
		returnUserName(id) {
            for (let i = 0; i < this.users.length; i++) {
                if (this.users[i].id == id) {
                    return this.users[i].name;
                }
            }
        },
		nextPage() {
			this.actPage++;
			this.rates.slice((this.actPage + this.perPage-1), (this.actPage * this.perPage));
			this.pagination();
        },
        prevPage() {
			this.actPage--;
			this.rates.slice((this.actPage + this.perPage-1), (this.actPage * this.perPage));
			this.pagination();
    	},
    	checkLength(length) {
			if (this.rates.length > length) return length
			else return this.rates.length
    	},
        pagination() {
			this.showRates = [];
			if (this.actPage == 1) {
				for (let i=this.actPage; i<=this.checkLength((this.actPage*this.perPage)); i++) {
					this.showRates.push(this.rates[i-1]);
				}
			} else {
				for (let i=(this.actPage-1)*this.perPage+1; i<=this.checkLength((this.actPage*this.perPage)); i++) {
					this.showRates.push(this.rates[i-1]);
				}
			}
			if (this.rates.length > this.perPage) {
				if (this.actPage == 1) document.getElementById("prev-page").style.visibility = 'hidden';
				else document.getElementById("prev-page").style.visibility = 'visible';
				if (this.rates.length < (this.perPage*this.actPage)-1) document.getElementById('next-page').style.visibility = 'hidden';
				else document.getElementById('next-page').style.visibility = 'visible';
			}
        }
	},
	mounted() {
		this.read();
		this.readRecipes();
		this.readUsers();
	}
}
</script>