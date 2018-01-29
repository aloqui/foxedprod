<template>
<div>


      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Submit Image</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                <!-- <span v-if="activity.image != 'none'">
                    <img :src="'http://localhost:8000/images/' + activity.image">
                </span> -->
                {{act}}
            <div class="d-flex flex-column justify-content-center align-items-center">

                <!-- <input  v-if="activity.type == 'image'" v-show="activity.user_id != authenticatedUser.id" type="file" class="form-control" @change="imageChanged">
                <input v-model="imageport.title" type="text" placeholder="title">
                <button @click="submitImage">save</button> -->
            </div>
          </div>
          <!-- <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" @click="onChange">Save changes</button>
          </div> -->
        </div>
      </div>
    </div>
</div>
</template>
<script>
export default {
  props: [
            'act'
        ]
}
</script>
