import {createRouter, createWebHistory} from 'vue-router';
// import UserIndex from "../pages/User/UserIndex.vue";
// const UserIndex = () => import('../pages/User/UserIndex.vue')
// const StudentIndex = () => import('../pages/Student/StudentIndex.vue')
// const ExamIndex = () => import('../pages/Exam/ExamIndex.vue')
// const CourseIndex = () => import('../pages/Course/CourseIndex.vue')
import Home from "../pages/Home/Home.vue";
import Course from "../pages/Course/CourseIndex.vue";
import StudentActivities from "../pages/Student/StudentActivities.vue";

const routes = [
    {path: '/teacher/home', name: 'home', component: Home},
    {path: '/teacher/course/:courseId', name: 'course', component: Course, props: true},
    {path: '/teacher/student-activities/:courseId/:studentId', name: 'student', component: StudentActivities, props: true},
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
