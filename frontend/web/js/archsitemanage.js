
function onViewOriginal(event){

    changePictures("image-origin");
}

function onViewDStretch(event){

    changePictures("image-dstretch");
}

function onViewDrawing(event){

    changePictures("image-drawing"); 
}

function onViewReconstraction(event){

    changePictures("image-reconstruction");
}
function onViewOverlay(event){

    changePictures("image-overlay"); 
}

function changePictures(newImages){
    let i = 0;
    let petroglyphs = document.getElementsByClassName("row");
    while(petroglyphs.item(i) !=null){
        if(petroglyphs.item(i).className != "row"){
            i++;
            continue;
        }
        let item = petroglyphs.item(i);
        let image = item.querySelector("div." + newImages) == null ?
                item.querySelector("div.image-origin"): item.querySelector("div." + newImages);

        if(image != null)
            image.style.display = 'block';
        
        let j = 0;
        while(item.children.item(j) != null){
            if(item.children.item(j).style.display != 'none' 
                && item.children.item(j) != image)
                item.children.item(j).style.display = 'none';
            j++;
        }
        i++;
    }
    $(".container").masonry({itemSelector: '.msnry'});
}

if (typeof vieworigin != "undefined") vieworigin.addEventListener("click", onViewOriginal);
if (typeof viewdstretch != "undefined") viewdstretch.addEventListener("click", onViewDStretch);
if (typeof viewdrawing != "undefined") viewdrawing.addEventListener("click", onViewDrawing);
if (typeof viewreconstruction != "undefined") viewreconstruction.addEventListener("click", onViewReconstraction);
if (typeof viewoverlay != "undefined") viewoverlay.addEventListener("click", onViewOverlay);