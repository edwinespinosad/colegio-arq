import { createRouter, createWebHistory } from 'vue-router';
// import UserIndex from "../pages/User/UserIndex.vue";
// const UserIndex = () => import('../pages/User/UserIndex.vue')
// const StudentIndex = () => import('../pages/Student/StudentIndex.vue')
// const ExamIndex = () => import('../pages/Exam/ExamIndex.vue')
// const CourseIndex = () => import('../pages/Course/CourseIndex.vue')

const routes = [
    // { path:'/', name:'home', component:HomeComponent},
    // { path: '/admin/users', name: 'users', component: UserIndex },
    // { path: '/admin/students', name: 'students', component: StudentIndex },
    // { path: '/admin/exams', name: 'exams', component: ExamIndex },
    // { path: '/admin/courses', name: 'courses', component: CourseIndex },
];
const router = createRouter({
    history: createWebHistory(),
    routes
});
export default router;
