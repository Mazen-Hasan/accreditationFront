
badge_size_array = [];
var badge_elements = [];
var elements_id = [];
var selected_obj;
badge_size_array.push(
    {
        id:1,
        size: {
            width: 53.98  / 25.4 * 96,
            height: 85.60 / 25.4 * 96,
        }
    },
    {
        id: 2,
        size: {
            width: 90 / 25.4 * 96,
            height: 140 / 25.4 * 96,
        }
    },
    {
        id: 3,
        size: {
            width: 70 / 25.4 * 96,
            height: 100 / 25.4 * 96,
        }
    }
);

let badge_size = {
    width: badge_size_array[0]["size"].width,
    height: badge_size_array[0]["size"].height,
};

$('#div-badge').width(badge_size.width);
$('#div-badge').height(badge_size.height);

$('input[type=radio][name=radio-size]').on('change', function() {
    const option = $(this).val();
    badge_size.width = badge_size_array[option]["size"].width;
    badge_size.height =  badge_size_array[option]["size"].height;
    $('#div-badge').width(badge_size.width);
    $('#div-badge').height(badge_size.height);
    stage.width(badge_size.width);
    stage.height(badge_size.height);
});


var width = badge_size.width;
var height = badge_size.height;
// var div_container = $('#div-badge');
// width = $('#div-badge').width();
// height = $('#div-badge').height();

var stage = new Konva.Stage({
    container: 'div-badge',
    width: width,
    height: height,
});

var layer = new Konva.Layer();



var tr = new Konva.Transformer({
    nodes: [],
    padding: 1,
    // enable only side anchors
    // enabledAnchors: ['middle-left', 'middle-right'],
    resizeEnabled: true,
    rotateEnabled: false,
    // limit transformer size
    // boundBoxFunc: (oldBox, newBox) => {
    //     if (newBox.width < MIN_WIDTH) {
    //         return oldBox;
    //     }
    //     return newBox;
    // },
});
layer.add(tr);

// add the layer to the stage
stage.add(layer);

// draw the image
layer.draw();



// add a new feature, lets add ability to draw selection rectangle
var selectionRectangle = new Konva.Rect({
    fill: 'rgba(0,0,255,0.5)',
    visible: false,
});
layer.add(selectionRectangle);

var x1, y1, x2, y2;
stage.on('mousedown touchstart', (e) => {
    // do nothing if we mousedown on any shape
    
    //showPros(e.target.attrs);
    //alert("hi");
    if (e.target !== stage) {
        return;
    }
    e.evt.preventDefault();
    x1 = stage.getPointerPosition().x;
    y1 = stage.getPointerPosition().y;
    x2 = stage.getPointerPosition().x;
    y2 = stage.getPointerPosition().y;

    selectionRectangle.visible(true);
    //selectionRectangle.width(0);
    //selectionRectangle.height(0);
    //showPros(e.target.attrs,e.target);
});

stage.on('mousemove touchmove', (e) => {
    // do nothing if we didn't start selection
    if (!selectionRectangle.visible()) {
        
        return;
    }
    e.evt.preventDefault();
    x2 = stage.getPointerPosition().x;
    y2 = stage.getPointerPosition().y;

    selectionRectangle.setAttrs({
        x: Math.min(x1, x2),
        y: Math.min(y1, y2),
        width: Math.abs(x2 - x1),
        height: Math.abs(y2 - y1),
    });
    //alert("hi");
    // $('#position-x').val(e.target.attrs.x);
    // $('#position-y').val(e.target.attrs.y);
    //showPros(e.target.attrs,e.target);
});

stage.on('mouseup touchend', (e) => {
    // do nothing if we didn't start selection
    if (!selectionRectangle.visible()) {
        return;
    }
    //alert("hi");
    e.evt.preventDefault();
    // update visibility in timeout, so we can check it in click event
    setTimeout(() => {
        selectionRectangle.visible(false);
    });

    var shapes = stage.find('.rect');
    var box = selectionRectangle.getClientRect();
    var selected = shapes.filter((shape) =>
        Konva.Util.haveIntersection(box, shape.getClientRect())
    );
    tr.nodes(selected);
    //showPros(e.target.attrs,e.target);
});

// clicks should select/deselect shapes
stage.on('click tap', function (e) {
    // if we are selecting with rect, do nothing
    if (selectionRectangle.visible()) {
        return;
    }

    // if click on empty area - remove all selections
    if (e.target === stage) {
        tr.nodes([]);
        return;
    }

    // // do nothing if clicked NOT on our rectangles
    // if (!e.target.hasName('rect')) {
    //     return;
    // }

    // do we pressed shift or ctrl?
    const metaPressed = e.evt.shiftKey || e.evt.ctrlKey || e.evt.metaKey;
    const isSelected = tr.nodes().indexOf(e.target) >= 0;

    showPros(e.target.attrs,e.target);
    if (!metaPressed && !isSelected) {
        // if no key pressed and the node is not selected
        // select just one

        tr.nodes([e.target]);

    } else if (metaPressed && isSelected) {
        // if we pressed keys and node was selected
        // we need to remove it from selection:
        const nodes = tr.nodes().slice(); // use slice to have new copy of array
        // remove node from array
        nodes.splice(nodes.indexOf(e.target), 1);
        tr.nodes(nodes);
    } else if (metaPressed && !isSelected) {
        // add the node into selection
        const nodes = tr.nodes().concat([e.target]);
        tr.nodes(nodes);
    }
});

// save stage as a json string
var json = stage.toJSON();

console.log(json);

function showPros(pros,obj) {
    selected_obj = obj;
    console.log(pros);
    $('#field-name').val(pros.type);
    $('#position-x').val(pros.x);
    $('#position-y').val(pros.y);
    $('#item-width').val(obj.width());
    $('#item-height').val(obj.height());
    if(pros.kind == 'text'){
        $('#font-size-container').show();
        $('#item-font-size').val(pros.fontSize);
        $('#font-container').show();
        $('#item-font-family').val(pros.fontFamily);
    }else{
        $('#font-size-container').hide();
        $('#font-container').hide();
    }
    $('#item-font-color').val(pros.fill);
    var json = stage.toJSON();
    console.log(json);

}


$('.personal_img_add').on('click', function() {
    console.log('hi');
    var id = $(this).data('id');
    var type = $(this).data('type');
    var item_id = "#"+this.id;
    var item = $(item_id);
    var action = item.html();
    if(type == 'rec'){
        if(action == 'add'){
            var rec = createRec(id);
            layer.add(rec);
            rec.on('transform', () => {
                // adjust size to scale
                // and set minimal size
                rec.width(Math.max(5, rec.width() * rec.scaleX()));
                rec.height(Math.max(5, rec.height() * rec.scaleY()));
                // reset scale to 1
                rec.scaleX(1);
                rec.scaleY(1);
              });
            elements_id.push(id);
            badge_elements.push(rec);
            var button_id = "#"+id;
            var button = $(button_id);
            button.html('remove');
        }else{
            selectionRectangle.visible(false);
            var button_id = "#"+id;
            var button = $(button_id);
            button.html('add');
            const index = elements_id.indexOf(id);
            if (index > -1) {
                elements_id.splice(index, 1); // 2nd parameter means remove one item only
                badge_elements[index].remove();
                badge_elements.splice(index, 1);
            }
            layer.draw();
        }
    }else{
        if(action == 'add'){
            var sampleText = createText(id);
            sampleText.on('transform', () => {
                // with enabled anchors we can only change scaleX
                // so we don't need to reset height
                // just width
                sampleText.fontSize(sampleText.fontSize() * sampleText.scaleX());
                sampleText.setAttrs({
                  width: Math.max(sampleText.width() * sampleText.scaleX()),
                  height: Math.max(sampleText.height() * sampleText.scaleY()),
                  scaleX: 1,
                  scaleY: 1,
                });
              });
            layer.add(sampleText);
            layer.add(tr);
            elements_id.push(id);
            badge_elements.push(sampleText);
            var button_id = "#"+id;
            var button = $(button_id);
            button.html('remove');
        }else{
            selectionRectangle.visible(false);
            var button_id = "#"+id;
            var button = $(button_id);
            button.html('add');
            const index = elements_id.indexOf(id);
            if (index > -1) {
                elements_id.splice(index, 1); // 2nd parameter means remove one item only
                badge_elements[index].remove();
                badge_elements.splice(index, 1);
            }
            layer.draw();
        }

    }
});


$('#update_color').on('click', function() {
    try{
        var entered_color = $('#item-font-color').val();
        selected_obj.fill(entered_color);
    }catch(err){
        console.log(err);
    }
});

$('#update_font').on('click', function() {
    try{
        var entered_font = $('#item-font-font').val();
        selected_obj.fontFamily(entered_font);
    }catch(err){
        console.log(err);
    }
});

function createRec(id){
    var rect1 = new Konva.Rect({
        x: 10,
        y: 10,
        width: 100,
        height: 90,
        fill: 'red',
        name: id,
        draggable: true,
        type: id,
        kind: 'rec'
    });
    return rect1;
}

function createText(id){
    var simpleText = new Konva.Text({
        x: 20,
        y: 150,
        text: id,
        fontSize: 30,
        fontFamily: 'Calibri',
        fill: 'red',
        name: id,
        draggable: true,
        type: id,
        kind: 'text'
    });
    return simpleText;
}