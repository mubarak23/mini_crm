import VueRouter from "vue-router";
// Pages
import Home from "./pages/Home";
import Register from "./pages/Register";
import Login from "./pages/Login";
import Dashboard from "./pages/user/Dashboard";
import EmployeeDashboard from "./pages/employee/Dashboard";
import AdminDashboard from "./pages/admin/Dashboard";
// Routes
const routes = [
    {
        path: "/",
        name: "home",
        component: Home,
        meta: {
            auth: undefined
        }
    },
    {
        path: "/register",
        name: "register",
        component: Register,
        meta: {
            auth: false
        }
    },
    {
        path: "/login",
        name: "login",
        component: Login,
        meta: {
            auth: false
        }
    },

    // ADMIN ROUTES
    {
        path: "/admin",
        name: "admin.dashboard",
        component: AdminDashboard,
        meta: {
            auth: {
                roles: 1,
                redirect: { name: "login" },
                forbiddenRedirect: "/403"
            }
        }
    },
    {
        path: "/employee",
        name: "employee.dashboard",
        component: EmployeeDashboard,
        meta: {
            auth: {
                roles: 2,
                redirect: { name: "login" },
                forbiddenRedirect: "/403"
            }
        }
    },
    //USER ROUTES
    {
        path: "/user",
        name: "user.dashboard",
        component: Dashboard,
        meta: {
            auth: {
                roles: 3,
                redirect: { name: "login" },
                forbiddenRedirect: "/403"
            }
        }
    }
];
const router = new VueRouter({
    history: true,
    mode: "history",
    routes
});
export default router;
