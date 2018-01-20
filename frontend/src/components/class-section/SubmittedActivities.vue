<template>
    <div>
        
        <h1>
            Activity : {{act}} <br>
            Name : {{submitted.class.title}} <br>
            About : {{submitted.class.body}}
        </h1>
        <div>
            <table class="table">
                <thead>
                    <tr>
                    <th>Title</th>
                    <th>Submitted By</th>
                    <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="act in submitted.userAct">
                    <td>{{act.title}}</td>
                    <td>
                        <router-link  :to="'/'+act.user.name +'/codes/' + act.id"><span>{{act.user.name}}</span></router-link>
                    </td>
                    <td>
                        <span v-for="sco in submitted.score">
                                        <span v-if="sco.user_id == act.user_id">
                                            {{sco.body}}
                                        </span> 
                                    </span> 
                    </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
export default {
    data (){
        return {
            act: JSON.parse(this.$route.params.id),
            submitted: []
        }
    },
    mounted() {
        this.$http.get(`api/activities/${this.$route.params.id}/eval`)
          .then(
            data => {
                console.log("HERE -> "+data.body.score)
                this.submitted = data.body;
            }
          );


      },
}
</script>
<style lang="scss" scoped>
h1{
    padding-top: 100px;
}
</style>

