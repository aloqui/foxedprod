export default {
  methods: {
    fixPicture() {

      //   console.log("hi")
      var picture = document.querySelectorAll(".picture")
      console.log(picture)
      picture[0].onload = function () {
        for (var i = 0; i < picture.length; i++) {
          console.log(picture[i].naturalHeight)
          console.log(picture[i].naturalWidth + " " + " " + picture[i].naturalHeight)
          if (picture[i].naturalWidth < picture[i].naturalHeight) {
            picture[i].style.width = `100%`
          } else {
            picture[i].style.height = `100%`
          }
        }

      }
    },
    // fixPictureOnRouteChange() {
    //   var picture = document.querySelectorAll(".picture")
    //   var done = false;
    //   console.log("route changed!")
    //   do {
    //     if (picture[0].naturalHeight != 0 && picture[0].naturalWidth != 0) {
    //       done = true
    //       hey()
    //     }
    //   } while (done == false)

    //   function hey() {
    //     if (done == true) {
    //       for (var i = 0; i < picture.length; i++) {
    //         console.log(picture[i].naturalHeight)
    //         console.log(picture[i].naturalWidth + " " + " " + picture[i].naturalHeight)
    //         if (picture[i].naturalWidth < picture[i].naturalHeight) {
    //           picture[i].style.width = `100%`
    //         } else {
    //           picture[i].style.height = `100%`
    //         }
    //       }
    //     }
    //   }

    // }
  }
}
