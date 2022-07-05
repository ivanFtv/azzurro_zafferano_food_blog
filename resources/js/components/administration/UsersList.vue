<template>
    <div class="container">
		<div class="row mt-5">
			<div class="col-sm-10 mx-auto">
				<h3>Tutti gli utenti registrati</h3>
			</div>
		</div>
		<div class="row mt-3">
			<div v-if="this.users.length > this.perPage" class="row">
				<nav aria-label="Page navigation example" class="d-flex justify-content-end" style="padding-right:7em !important;">
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
							<th class="p-2 px-4 m-2">Registered Date</th>
							<th class="p-2 px-4 m-2">Name</th>
							<th class="p-2 px-4 m-2">Lastname</th>
							<th class="p-2 px-4 m-2">Email</th>
							<th class="p-2 px-4 m-2">Role</th>
							<th class="p-2 px-4 m-2 text-center">Actions</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="user in showUsers" :key="user.id" class="p-2 m-2">
							<th class="p-2 px-4 m-2">{{ user.id }}</th>
							<td class="p-2 px-4 m-2">{{ moment(user.created_at).format('DD/MM/YYYY') }}</td>
							<td class="p-2 m-2">{{ user.name }}</td>
							<td class="p-2 m-2">{{ user.lastname }}</td>
							<td class="p-2 px-4 m-2">{{ user.email }}</td>
							<td class="p-2 px-4 m-2"><select name="" @change="update($event, user.id)" :disabled="isDisable(user.role)">
									<option v-for="role in roles" 
									:key="role.id" 
									:value="role.id" 
									:selected="role.id === user.role ? 'selected' : ''"
									>{{ role.name }}</option>
								</select></td>
							<td class="m-2 text-center">
								<button  
								v-if="user.role > actUser.role" 
								class="btn btn-sm btn-danger mx-2" 
								@click="del(user.id)">Delete</button>
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
	props: ['actUser'],
	data(){
		return {
			moment: moment,
			users: [],
			showUsers: [],
			actPage: 1,
			perPage: 10,
			roles: [
				{id: 0, name: 'Founder'},
				{id: 1, name: 'Administrator'},
				{id: 2, name: 'Editor'},
				{id: 3, name: 'Guest'},
				]
		}
	},
	methods: {
		 async read() {
          await axios.get('/api/users') .then(response => {
            response.data.forEach(element => {
              this.users.push(element)
            });
        });
		this.pagination();
        },
		async del(id) {
			await axios.delete(`/api/delete/user/${id}`);
			let index = this.showUsers.findIndex((element) => element.id == id);
			this.showUsers.splice(index, 1);
		},
		async update(event, id) {
			const newRole = event.target.selectedOptions[0].value;
			await axios.put('/api/users/' + id, {'role': newRole});
			this.users.find((user) => user.id === id).role = newRole;
		},
		isDisable(role) {
			if (role <= this.actUser.role) return true;
		},
		nextPage() {
			this.actPage++;
			this.users.slice((this.actPage + this.perPage-1), (this.actPage * this.perPage));
			this.pagination();
        },
        prevPage() {
			this.actPage--;
			this.users.slice((this.actPage + this.perPage-1), (this.actPage * this.perPage));
			this.pagination();
    	},
    	checkLength(length) {
			if (this.users.length > length) return length
			else return this.users.length
    	},
        pagination() {
			this.showUsers = [];
			if (this.actPage == 1) {
				for (let i=this.actPage; i<=this.checkLength((this.actPage * this.perPage)); i++) {
					this.showUsers.push(this.users[i-1]);
				}
			} else {
				for (let i=(this.actPage-1)*this.perPage+1; i<=this.checkLength((this.actPage*this.perPage)); i++) {
					this.showUsers.push(this.users[i-1]);
				}
			}
			if (this.users.length > this.perPage) {
				if (this.actPage == 1) document.getElementById('prev-page').style.visibility = 'hidden';
				else document.getElementById('prev-page').style.visibility = 'visible';
				if (this.users.length < (this.perPage*this.actPage)-1) document.getElementById('next-page').style.visibility = 'hidden';
				else document.getElementById('next-page').style.visibility = 'visible';
			}
        }
	},
	mounted() {
		this.read();
	},
}
</script>