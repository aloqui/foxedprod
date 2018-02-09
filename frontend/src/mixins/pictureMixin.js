export default {
    methods: {
        fixPicture() {
            var picture = document.querySelectorAll(".picture")
                // console.log(picture)
            picture[0].onload = function() {
                for (var i = 0; i < picture.length; i++) {

                    // console.log(picture[i].naturalHeight)
                    // console.log(picture[i].naturalWidth + " " + " " + picture[i].naturalHeight)
                    if (picture[i].naturalWidth < picture[i].naturalHeight) {
                        picture[i].style.width = `100%`
                    } else {
                        picture[i].style.height = `100%`
                    }

                }
            }
        }
    }
}