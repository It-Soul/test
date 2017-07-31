/* ***** BEGIN LICENSE BLOCK *****
 * Distributed under the BSD license:
 *
 * Copyright (c) 2010, Ajax.org B.V.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of Ajax.org B.V. nor the
 *       names of its contributors may be used to endorse or promote products
 *       derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL AJAX.ORG B.V. BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * ***** END LICENSE BLOCK ***** */

define('ace/theme/xcode', ['require', 'exports', 'module' , 'ace/lib/dom'], function(require, exports, module) {

exports.isDark = false;
exports.cssClass = "ace-xcode";
exports.cssText = "/* THIS THEME WAS AUTOGENERATED BY Theme.tmpl.css (UUID: EE3AD170-2B7F-4DE1-B724-C75F13FE0085) */\
.ace-xcode .ace_gutter {\
background: #e8e8e8;\
color: #333\
}\
.ace-xcode .ace_print-margin {\
width: 1px;\
background: #e8e8e8\
}\
.ace-xcode {\
background-color: #FFFFFF;\
color: #000000\
}\
.ace-xcode .ace_cursor {\
border-left: 2px solid #000000\
}\
.ace-xcode .ace_overwrite-cursors .ace_cursor {\
border-left: 0px;\
border-bottom: 1px solid #000000\
}\
.ace-xcode .ace_marker-layer .ace_selection {\
background: #B5D5FF\
}\
.ace-xcode.ace_multiselect .ace_selection.ace_start {\
box-shadow: 0 0 3px 0px #FFFFFF;\
border-radius: 2px\
}\
.ace-xcode .ace_marker-layer .ace_step {\
background: rgb(198, 219, 174)\
}\
.ace-xcode .ace_marker-layer .ace_bracket {\
margin: -1px 0 0 -1px;\
border: 1px solid #BFBFBF\
}\
.ace-xcode .ace_marker-layer .ace_active-line {\
background: rgba(0, 0, 0, 0.071)\
}\
.ace-xcode .ace_gutter-active-line {\
background-color: rgba(0, 0, 0, 0.071)\
}\
.ace-xcode .ace_marker-layer .ace_selected-word {\
border: 1px solid #B5D5FF\
}\
.ace-xcode .ace_constant.ace_language,\
.ace-xcode .ace_keyword,\
.ace-xcode .ace_meta,\
.ace-xcode .ace_variable.ace_language {\
color: #C800A4\
}\
.ace-xcode .ace_invisible {\
color: #BFBFBF\
}\
.ace-xcode .ace_constant.ace_character,\
.ace-xcode .ace_constant.ace_other {\
color: #275A5E\
}\
.ace-xcode .ace_constant.ace_numeric {\
color: #3A00DC\
}\
.ace-xcode .ace_entity.ace_other.ace_attribute-name,\
.ace-xcode .ace_support.ace_constant,\
.ace-xcode .ace_support.ace_function {\
color: #450084\
}\
.ace-xcode .ace_fold {\
background-color: #C800A4;\
border-color: #000000\
}\
.ace-xcode .ace_entity.ace_name.ace_tag,\
.ace-xcode .ace_support.ace_class,\
.ace-xcode .ace_support.ace_type {\
color: #790EAD\
}\
.ace-xcode .ace_storage {\
color: #C900A4\
}\
.ace-xcode .ace_string {\
color: #DF0002\
}\
.ace-xcode .ace_comment {\
color: #008E00\
}\
.ace-xcode .ace_indent-guide {\
background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAACCAYAAACZgbYnAAAAE0lEQVQImWP4////f4bLly//BwAmVgd1/w11/gAAAABJRU5ErkJggg==) right repeat-y\
}";

var dom = require("../lib/dom");
dom.importCssString(exports.cssText, exports.cssClass);
});
