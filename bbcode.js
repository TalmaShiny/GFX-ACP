// *******************************************************
// Sprache ***********************************************
// *******************************************************
tag_prompt = "Gebe einen Text ein:";
font_formatter_prompt = "Gebe einen Text ein - ";
link_text_prompt = "Gebe einen Linknamen ein (optional)";
link_url_prompt = "Gebe die volle Adresse des Links ein";
link_email_prompt = "Gebe eine Email Adesse ein";
list_type_prompt = "was für eine Liste möchtest du? Gebe '1' ein für eine nummerierte Liste, 'a' für ein alphabetische, oder gar nichts für eine einfache Punktliste.";
list_item_prompt = "Gebe eine Listepunkt ein.\nGebe nichts ein oder drücke 'Cancel' um die Liste fertigzustellen.";
// *******************************************************

tags = new Array();

function getarraysize(thearray) {
    for (i = 0; i < thearray.length; i++) {
        if ((thearray[i] == "undefined") || (thearray[i] == "") || (thearray[i] == null)) return i;
    }
    return thearray.length;
}

function arraypush(thearray, value) {
    thearraysize = getarraysize(thearray);
    thearray[thearraysize] = value;
}

function arraypop(thearray) {
    thearraysize = getarraysize(thearray);
    retval = thearray[thearraysize - 1];
    delete thearray[thearraysize - 1];
    return retval;
}

// *******************************************************

function setmode(modevalue) {
    document.cookie = "bbcodemode=" + modevalue + "; path=/; expires=Wed, 1 Jan 2020 00:00:00 GMT;";
}

function normalmode(theform) {
    return true;
}

function stat(thevalue) {
    document.bbform.status.value = eval(thevalue + "_text");
}

function setfocus(theform) {
    theform.message.focus();
}

function closetag(theform) {
    if (!normalmode(theform)) {
        if (tags[0]) theform.message.value += "[/" + arraypop(tags) + "]";
    }
    setfocus(theform);
}

function closeall(theform) {
    if (!normalmode(theform)) {
        if (tags[0]) {
            while (tags[0]) {
                theform.message.value += "[/" + arraypop(tags) + "]";
            }
            theform.message.value += " ";
        }
    }
    setfocus(theform);
}

// *******************************************************
var selectedText = "";
AddTxt = "";

function getActiveText(msg) {
    selectedText = (document.all) ? document.selection.createRange().text : document.getSelection();
    if (msg.createTextRange) msg.caretPos = document.selection.createRange().duplicate();
    return true;
}

function AddText(NewCode, theform) {
    if (theform.message.createTextRange && theform.message.caretPos) {
        var caretPos = theform.message.caretPos;
        caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? NewCode + ' ' : NewCode;
    } else theform.message.value += NewCode
    AddTxt = "";
    setfocus(theform);
}

function bbcode(theform, bbcode, prompttext) {
    setfocus(theform);
    if ((normalmode(theform)) || (bbcode == "IMG")) {
        if (selectedText != "") var dtext = selectedText;
        else var dtext = prompttext;
        inserttext = prompt(tag_prompt + "\n[" + bbcode + "]xxx[/" + bbcode + "]", dtext);
        if ((inserttext != null) && (inserttext != "")) {
            AddTxt = "[" + bbcode + "]" + inserttext + "[/" + bbcode + "] ";
            AddText(AddTxt, theform);
        }
    }
    else {
        donotinsert = false;
        for (i = 0; i < tags.length; i++) {
            if (tags[i] == bbcode) donotinsert = true;
        }
        if (!donotinsert) {
            theform.message.value += "[" + bbcode + "]";
            arraypush(tags, bbcode);
        }
    }
    setfocus(theform);
}

// *******************************************************

function fontformat(theform, thevalue, thetype) {
    setfocus(theform);
    if (normalmode(theform)) {
        if (thevalue != 0) {
            if (selectedText) var dtext = selectedText;
            else var dtext = "";
            inserttext = prompt(font_formatter_prompt + " " + thetype, dtext);
            if ((inserttext != null) && (inserttext != "")) {
                AddTxt = "[" + thetype + "=" + thevalue + "]" + inserttext + "[/" + thetype + "] ";
                AddText(AddTxt, theform);
            }
        }
    }
    else {
        theform.message.value += "[" + thetype + "=" + thevalue + "]";
        arraypush(tags, thetype);
    }
    theform.sizeselect.selectedIndex = 0;
    theform.fontselect.selectedIndex = 0;
    theform.colorselect.selectedIndex = 0;
    setfocus(theform);
}

// *******************************************************

function namedlink(theform, thetype) {
    if (selectedText) {
        var dtext = selectedText;
    } else {
        var dtext = "";
    }
    linktext = prompt(link_text_prompt, dtext);
    var prompttext;
    if (thetype == "URL") {
        prompt_text = link_url_prompt;
        prompt_contents = "http://";
    }
    else {
        prompt_text = link_email_prompt;
        prompt_contents = "";
    }
    linkurl = prompt(prompt_text, prompt_contents);
    if ((linkurl != null) && (linkurl != "") && (linkurl.indexOf('"') < 0)) {
        if ((linktext != null) && (linktext != "")) {
            AddTxt = "[" + thetype + "=" + linkurl + "]" + linktext + "[/" + thetype + "] ";
            AddText(AddTxt, theform);

        }
        else {
            AddTxt = "[" + thetype + "]" + linkurl + "[/" + thetype + "] ";
            AddText(AddTxt, theform);

        }
    }
}

// *******************************************************

function dolist(theform) {
    listtype = prompt(list_type_prompt, "");
    if ((listtype == "a") || (listtype == "1")) {
        thelist = "[list=" + listtype + "]\n";
        listend = "[/list] ";
    }
    else {
        thelist = "[list]\n";
        listend = "[/list] ";
    }
    listentry = "initial";
    while ((listentry != "") && (listentry != null)) {
        listentry = prompt(list_item_prompt, "");
        if ((listentry != "") && (listentry != null))
            thelist = thelist + "[*]" + listentry + "\n";
    }
    AddTxt = thelist + listend;
    AddText(AddTxt, theform);

}

// *******************************************************

function smilie(thesmilie) {
    AddSmile = " " + thesmilie + " ";
    theform = document.bbform;
    AddText(AddSmile, theform);
}
