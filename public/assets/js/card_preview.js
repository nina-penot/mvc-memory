const input = document.querySelector("#pkmn_id");

const input_type = document.querySelector("#card_type");
const input_name = document.querySelector("#card_name");
var image = document.getElementById("img");
var type_back = document.getElementById("background");
var card_name = document.getElementById("cname");

input.addEventListener("input", updateValue);
input_type.addEventListener("input", updateType);
input_name.addEventListener("input", updateName);

function updateValue(e) {
    num = e.target.value;
    if (num < 1 || num == "" || num > 1025) {
        var img_link = "https://upload.wikimedia.org/wikipedia/commons/thumb/d/d9/Icon-round-Question_mark.svg/1024px-Icon-round-Question_mark.svg.png"
    } else {
        var img_link = "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/" + num + ".png";
    }
    image.src = img_link;
    //console.log(num);
}

function updateType(a) {
    type = a.target.value;
    type_back.className = "";
    type_back.classList.add("card_main", "card_front", "center", "gradient_" + type);

    console.log(type_back.className);
    console.log(type);
}

function updateName(i) {
    console.log(i.target.value);
    var myname = i.target.value;
    myname = myname.toUpperCase();
    card_name.textContent = myname;
}