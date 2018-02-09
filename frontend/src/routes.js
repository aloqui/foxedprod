import Vue from 'vue'
import VueRouter from 'vue-router'

import Login from './components/authentication/Login.vue'
import Register from './components/authentication/Register.vue'
import Feed from './components/Feed.vue'
import Profile from './components/Profile.vue'
import Editor from './components/editor/Editor.vue'
import EditEditor from './components/editor/CodeEdit.vue'
import ViewEditor from './components/editor/CodeView.vue'
import ActivityEditor from './components/editor/ActivityEditor.vue'
import Thread from './components/forum/Thread.vue'
import Create from './components/forum/Ask.vue'
import Edit from './components/forum/EditThread.vue'
import Class from './components/class-section/Classroom.vue'
import Evaluation from './components/class-section/Evaluation.vue'
import CreateActivity from './components/class-section/CreateActivity.vue'
import ViewActivity from './components/class-section/ViewActivity.vue'
import Activity from './components/class-section/Activities.vue'
import SubmittedActivity from './components/class-section/SubmittedActivities.vue'
import UpdateActivity from './components/class-section/EditActivity.vue'
import CreateClassroom from './components/class-section/CreateClassroom'
import Forum from './views/forums.vue'
import ForumCategory from './views/forum-topics.vue'
import sampleThread from './views/sample-thread.vue'
import createThread from './views/create-thread.vue'
import CreateCategory from './views/create-category.vue'
import Home from './views/home.vue'
import MyThread from './views/myThread.vue'
import Welcome from './views/welcome.vue'
import ConfirmAccount from './views/confirm-account.vue'
import SearchThreads from './views/search-threads.vue'
import PasswordReset from './views/reset-password.vue'
import PasswordResetOn from './views/reset/reset-password-on.vue'
import ProfileEdit from './views/user-profile/user-edit-profile.vue'


Vue.use(VueRouter)
window.axios = require('axios');
const router = new VueRouter({
    routes: [{
            path: "/discover",
            component: Welcome,
            meta: {
                forVisitors: true
            }
        },
        {
            path: "/register",
            component: Register,
            meta: {
                forVisitors: true
            }
        },
        {
            path: "/register/confirm",
            component: ConfirmAccount,
            meta: {
                forVisitors: false
            }
        },
        {
            path: "/activity/:id/evaluate",
            component: SubmittedActivity,
            meta: {
                forAuth: true
            }
        },
        {
            path: "/activity",
            component: Activity,
            meta: {
                forAuth: true
            }
        },
        {
            path: "/activity/create",
            component: CreateActivity,
            meta: {
                forAuth: true
            }
        },
        {
            path: "/activity/:activity",
            component: ViewActivity,
            meta: {
                forAuth: true
            }
        },
        {
            path: "/activity/:id/update",
            component: UpdateActivity,
            meta: {
                forAuth: true
            }
        },
        {
            path: "/class/create",
            component: CreateClassroom,
            meta: {
                forAuth: true
            }
        },
        // {
        //     path: "/community/create",
        //     component: createThread,
        //     meta: {
        //         forAuth: true
        //     }
        // },
        {

            path: "/community",
            component: Forum,
            meta: {
                forAuth: false
            }
        },
        {

            path: "/community/create",
            component: CreateCategory,
            meta: {
                forAuth: true
            }
        },

        {

            path: "/community/:slug",
            component: ForumCategory,
            meta: {
                forAuth: false
            }
        },
        {

            path: "/community/:slug/create",
            component: createThread,
            meta: {
                forAuth: true
            }
        },

        {
            path: '/community/:slug/:id',
            component: sampleThread,
            meta: {
                forAuth: false
            }
        },
        {
            path: "/replies",
            component: Thread,
            meta: {
                forAuth: true
            }
        },
        {
            path: "/feed/create",
            component: Create,
            meta: {
                forAuth: true
            }
        },
        {
            path: "/feed/:thread/edit",
            component: Edit,
            meta: {
                forAuth: true
            }
        },
        {
            path: "/:user/codes",
            component: Profile,
            meta: {
                forAuth: false
            }
        },
        {
            path: "/:user/threads",
            component: MyThread,
            meta: {
                forAuth: false
            }
        },
        {
            path: "/:user/codes/:id",
            component: EditEditor,
            meta: {
                forAuth: false
            }
        },
        {
            path: "/threads/search",
            component: SearchThreads,
            meta: {
                forAuth: false
            }
        },
        {
            path: "/class/:id",
            component: Class,
            meta: {
                forAuth: true
            }
        },
        {
            path: "/editor",
            component: Editor,
            meta: {
                forAuth: false
            }
        },
        {
            path: "/:id/activity",
            component: ActivityEditor,
            meta: {
                forAuth: true
            }
        },
        {
            path: "/:id/editor",
            component: Editor,
            meta: {
                forAuth: true
            }
        },
        {
            path: "/evaluation",
            component: Evaluation,
            meta: {
                forAuth: true
            }
        },
        {
            path: "/account/forgot_password",
            component: PasswordReset,
            meta: {
                forAuth: false
            }
        },
        {
            path: "/reset/account",
            component: PasswordResetOn,
            meta: {
                forAuth: false
            }
        },
        {
            path: "/:user/account",
            component: ProfileEdit,
            meta: {
                forAuth: true
            }
        },
        {
            path: "/",
            component: Home,
            meta: {
                forAuth: true
            }
        }
    ],
    // linkActiveClass:'active' 
    // ^ for active classes

    // mode: 'history 
    // ^to remove the hashtag
})

export default router