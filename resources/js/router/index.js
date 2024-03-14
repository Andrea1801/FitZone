import { createRouter, createWebHistory } from 'vue-router'
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import Home from '../views/Home.vue'
import Services from '../views/Services.vue'
import Account from '../views/Account.vue'
import Users from '../views/administration/Users.vue'
import Coach from '../views/administration/Coach.vue'
import Trainings from '../views/administration/Trainings.vue'
import Member from '../views/Member.vue'
import Categories from '../views/Categories.vue'
import Members from '../views/administration/Members.vue'
import Search from '../views/Search.vue'

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'login',
            component: Login
        },

        {
            path:'/register',
            name: 'register',
            component: Register
        },
        {
            path:'/home',
            name: 'home',
            component: Home,
        
        },
        {
            path:'/services',
            name: 'services',
            component: Services
        },
        {
            path:'/account',
            name: 'account',
            component: Account
        },
        {
            path:'/users',
            name: 'users',
            component: Users,
        },
        {
            path:'/coach',
            name: 'coach',
            component: Coach
        },
        {
            path:'/trainings',
            name: 'trainings',
            component: Trainings
        },
        {
            path:'/member',
            name: 'member',
            component: Member
        },
        {
            path:'/categories',
            name: 'categories',
            component: Categories
        },
        {
            path:'/members',
            name: 'members',
            component: Members
        },
        {
            path:'/search',
            name:'search',
            component: Search
        }
    ]
})


export default router
