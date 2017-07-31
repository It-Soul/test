﻿/*
 Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
 */

/**
 * @fileOverview Defines the {@link CKEDITOR.lang} object, for the
 * Chinese Simplified language.
 */

/**#@+
 @type String
 @example
 */

/**
 * Contains the dictionary of language entries.
 * @namespace
 */
CKEDITOR.lang['zh-cn'] =
{
    /**
     * The language reading direction. Possible values are "rtl" for
     * Right-To-Left languages (like Arabic) and "ltr" for Left-To-Right
     * languages (like English).
     * @default 'ltr'
     */
    dir: 'ltr',

    /*
     * Screenreader titles. Please note that screenreaders are not always capable
     * of reading non-English words. So be careful while translating it.
     */
    editorTitle: '富文本编辑器，%1',
    editorHelp: '按 ALT+0 获得帮助',

    // ARIA descriptions.
    toolbars: '工具栏',
    editor: '所见即所得编辑器',

    // Toolbar buttons without dialogs.
    source: '源码',
    newPage: '新建',
    save: '保存',
    preview: '预览',
    cut: '剪切',
    copy: '复制',
    paste: '粘贴',
    print: '打印',
    underline: '下划线',
    bold: '加粗',
    italic: '倾斜',
    selectAll: '全选',
    removeFormat: '清除格式',
    strike: '删除线',
    subscript: '下标',
    superscript: '上标',
    horizontalrule: '插入水平线',
    pagebreak: '插入分页符',
    pagebreakAlt: '分页符',
    unlink: '取消超链接',
    undo: '撤消',
    redo: '重做',

    // Common messages and labels.
    common: {
        browseServer: '浏览服务器',
        url: '源文件',
        protocol: '协议',
        upload: '上传',
        uploadSubmit: '上传到服务器上',
        image: '图象',
        flash: 'Flash',
        form: '表单',
        checkbox: '复选框',
        radio: '单选按钮',
        textField: '单行文本',
        textarea: '多行文本',
        hiddenField: '隐藏域',
        button: '按钮',
        select: '列表/菜单',
        imageButton: '图像域',
        notSet: '<没有设置>',
        id: 'ID',
        name: '名称',
        langDir: '语言方向',
        langDirLtr: '从左到右 (LTR)',
        langDirRtl: '从右到左 (RTL)',
        langCode: '语言代码',
        longDescr: '详细说明地址',
        cssClass: '样式类名称',
        advisoryTitle: '标题',
        cssStyle: '行内样式',
        ok: '确定',
        cancel: '取消',
        close: '关闭',
        preview: '预览',
        generalTab: '常规',
        advancedTab: '高级',
        validateNumberFailed: '需要输入数字格式',
        confirmNewPage: '当前文档内容未保存,是否确认新建文档？',
        confirmCancel: '部分修改尚未保存，是否确认关闭对话框？',
        options: '选项',
        target: '目标窗口',
        targetNew: '新窗口 (_blank)',
        targetTop: '整页 (_top)',
        targetSelf: '本窗口 (_self)',
        targetParent: '父窗口 (_parent)',
        langDirLTR: '从左到右 (LTR)',
        langDirRTL: '从右到左 (RTL)',
        styles: '样式',
        cssClasses: '样式类',
        width: '宽度',
        height: '高度',
        align: '对齐方式',
        alignLeft: '左对齐',
        alignRight: '右对齐',
        alignCenter: '居中',
        alignTop: '顶端',
        alignMiddle: '居中',
        alignBottom: '底部',
        invalidHeight: '高度必须为数字格式',
        invalidWidth: '宽度必须为数字格式',
        invalidCssLength: '该字段必须为合式的CSS长度值，包括单位(px, %, in, cm, mm, em, ex, pt 或 pc)',
        invalidHtmlLength: '该字段必须为合式的HTML长度值，包括单位(px 或 %)',
        invalidInlineStyle: '内联样式必须为格式是以分号分隔的一个或多个“属性名 : 属性值”',
        cssLengthTooltip: '该字段必须为合式的CSS长度值，包括单位(px, %, in, cm, mm, em, ex, pt 或 pc)',

        // Put the voice-only part of the label in the span.
        unavailable: '%1<span class="cke_accessibility">, 不可用</span>'
    },

    contextmenu: {
        options: '快捷菜单选项'
    },

    // Special char dialog.
    specialChar: {
        toolbar: '插入特殊符号',
        title: '选择特殊符号',
        options: '特殊符号选项'
    },

    // Link dialog.
    link: {
        toolbar: '插入/编辑超链接',
        other: '<其他>',
        menu: '编辑超链接',
        title: '超链接',
        info: '超链接信息',
        target: '目标',
        upload: '上传',
        advanced: '高级',
        type: '超链接类型',
        toUrl: '地址',
        toAnchor: '页内锚点链接',
        toEmail: '电子邮件',
        targetFrame: '<框架>',
        targetPopup: '<弹出窗口>',
        targetFrameName: '目标框架名称',
        targetPopupName: '弹出窗口名称',
        popupFeatures: '弹出窗口属性',
        popupResizable: '可缩放',
        popupStatusBar: '状态栏',
        popupLocationBar: '地址栏',
        popupToolbar: '工具栏',
        popupMenuBar: '菜单栏',
        popupFullScreen: '全屏 (IE)',
        popupScrollBars: '滚动条',
        popupDependent: '依附 (NS)',
        popupLeft: '左',
        popupTop: '右',
        id: 'ID',
        langDir: '语言方向',
        langDirLTR: '从左到右 (LTR)',
        langDirRTL: '从右到左 (RTL)',
        acccessKey: '访问键',
        name: '名称',
        langCode: '语言代码',
        tabIndex: 'Tab 键次序',
        advisoryTitle: '标题',
        advisoryContentType: '内容类型',
        cssClasses: '样式类名称',
        charset: '字符编码',
        styles: '行内样式',
        rel: '关联',
        selectAnchor: '选择一个锚点',
        anchorName: '按锚点名称',
        anchorId: '按锚点 ID',
        emailAddress: '地址',
        emailSubject: '主题',
        emailBody: '内容',
        noAnchors: '(此文档没有可用的锚点)',
        noUrl: '请输入超链接地址',
        noEmail: '请输入电子邮件地址'
    },

    // Anchor dialog
    anchor: {
        toolbar: '插入/编辑锚点链接',
        menu: '锚点链接属性',
        title: '锚点链接属性',
        name: '锚点名称',
        errorName: '请输入锚点名称',
        remove: '删除锚点'
    },

    // List style dialog
    list: {
        numberedTitle: '编号列表属性',
        bulletedTitle: '项目列表属性',
        type: '标记类型',
        start: '开始序号',
        validateStartNumber: '列表开始序号必须为整数格式',
        circle: '空心圆',
        disc: '实心圆',
        square: '实心方块',
        none: '无标记',
        notset: '<没有设置>',
        armenian: '传统的亚美尼亚编号方式',
        georgian: '传统的乔治亚编号方式(an, ban, gan, 等)',
        lowerRoman: '小写罗马数字(i, ii, iii, iv, v, 等)',
        upperRoman: '大写罗马数字(I, II, III, IV, V, 等)',
        lowerAlpha: '小写英文字母(a, b, c, d, e, 等)',
        upperAlpha: '大写英文字母(A, B, C, D, E, 等)',
        lowerGreek: '小写希腊字母(alpha, beta, gamma, 等)',
        decimal: '数字 (1, 2, 3, 等)',
        decimalLeadingZero: '0开头的数字标记(01, 02, 03, 等)'
    },

    // Find And Replace Dialog
    findAndReplace: {
        title: '查找和替换',
        find: '查找',
        replace: '替换',
        findWhat: '查找:',
        replaceWith: '替换:',
        notFoundMsg: '指定文本没有找到',
        findOptions: '查找选项',
        matchCase: '区分大小写',
        matchWord: '全字匹配',
        matchCyclic: '循环匹配',
        replaceAll: '全部替换',
        replaceSuccessMsg: '共完成 %1 处替换.'
    },

    // Table Dialog
    table: {
        toolbar: '表格',
        title: '表格属性',
        menu: '表格属性',
        deleteTable: '删除表格',
        rows: '行数',
        columns: '列数',
        border: '边框',
        widthPx: '像素',
        widthPc: '百分比',
        widthUnit: '宽度单位',
        cellSpace: '间距',
        cellPad: '边距',
        caption: '标题',
        summary: '摘要',
        headers: '标题单元格',
        headersNone: '无',
        headersColumn: '第一列',
        headersRow: '第一行',
        headersBoth: '第一列和第一行',
        invalidRows: '指定的列数必须大于零',
        invalidCols: '指定的行数必须大于零',
        invalidBorder: '边框粗细必须为数字格式',
        invalidWidth: '表格宽度必须为数字格式',
        invalidHeight: '表格高度必须为数字格式',
        invalidCellSpacing: '单元格间距必须为数字格式',
        invalidCellPadding: '单元格填充必须为数字格式',

        cell: {
            menu: '单元格',
            insertBefore: '在左侧插入单元格',
            insertAfter: '在右侧插入单元格',
            deleteCell: '删除单元格',
            merge: '合并单元格',
            mergeRight: '向右合并单元格',
            mergeDown: '向下合并单元格',
            splitHorizontal: '水平拆分单元格',
            splitVertical: '垂直拆分单元格',
            title: '单元格属性',
            cellType: '单元格类型',
            rowSpan: '纵跨行数',
            colSpan: '横跨列数',
            wordWrap: '自动换行',
            hAlign: '水平对齐',
            vAlign: '垂直对齐',
            alignBaseline: '基线',
            bgColor: '背景颜色',
            borderColor: '边框颜色',
            data: '数据',
            header: '表头',
            yes: '是',
            no: '否',
            invalidWidth: '单元格宽度必须为数字格式',
            invalidHeight: '单元格高度必须为数字格式',
            invalidRowSpan: '行跨度必须为整数格式',
            invalidColSpan: '列跨度必须为整数格式',
            chooseColor: '选择'
        },

        row: {
            menu: '行',
            insertBefore: '在上方插入行',
            insertAfter: '在下方插入行',
            deleteRow: '删除行'
        },

        column: {
            menu: '列',
            insertBefore: '在左侧插入列',
            insertAfter: '在右侧插入列',
            deleteColumn: '删除列'
        }
    },

    // Button Dialog.
    button: {
        title: '按钮属性',
        text: '标签(值)',
        type: '类型',
        typeBtn: '按钮',
        typeSbm: '提交',
        typeRst: '重设'
    },

    // Checkbox and Radio Button Dialogs.
    checkboxAndRadio: {
        checkboxTitle: '复选框属性',
        radioTitle: '单选按钮属性',
        value: '选定值',
        selected: '已勾选'
    },

    // Form Dialog.
    form: {
        title: '表单属性',
        menu: '表单属性',
        action: '动作',
        method: '方法',
        encoding: '表单编码'
    },

    // Select Field Dialog.
    select: {
        title: '菜单/列表属性',
        selectInfo: '选择信息',
        opAvail: '可选项',
        value: '值',
        size: '高度',
        lines: '行',
        chkMulti: '允许多选',
        opText: '选项文本',
        opValue: '选项值',
        btnAdd: '添加',
        btnModify: '修改',
        btnUp: '上移',
        btnDown: '下移',
        btnSetValue: '设为初始选定',
        btnDelete: '删除'
    },

    // Textarea Dialog.
    textarea: {
        title: '多行文本属性',
        cols: '字符宽度',
        rows: '行数'
    },

    // Text Field Dialog.
    textfield: {
        title: '单行文本属性',
        name: '名称',
        value: '初始值',
        charWidth: '字符宽度',
        maxChars: '最多字符数',
        type: '类型',
        typeText: '文本',
        typePass: '密码'
    },

    // Hidden Field Dialog.
    hidden: {
        title: '隐藏域属性',
        name: '名称',
        value: '初始值'
    },

    // Image Dialog.
    image: {
        title: '图象属性',
        titleButton: '图像域属性',
        menu: '图象属性',
        infoTab: '图象',
        btnUpload: '上传到服务器上',
        upload: '上传',
        alt: '替换文本',
        lockRatio: '锁定比例',
        resetSize: '原始尺寸',
        border: '边框大小',
        hSpace: '水平间距',
        vSpace: '垂直间距',
        alertUrl: '请输入图象地址',
        linkTab: '链接',
        button2Img: '确定要把当前按钮改变为图像吗?',
        img2Button: '确定要把当前图像改变为按钮吗?',
        urlMissing: '缺少图像源文件地址',
        validateBorder: '边框大小必须为整数格式',
        validateHSpace: '水平间距必须为整数格式',
        validateVSpace: '垂直间距必须为整数格式'
    },

    // Flash Dialog
    flash: {
        properties: 'Flash 属性',
        propertiesTab: '属性',
        title: '标题',
        chkPlay: '自动播放',
        chkLoop: '循环',
        chkMenu: '启用 Flash 菜单',
        chkFull: '启用全屏',
        scale: '缩放',
        scaleAll: '全部显示',
        scaleNoBorder: '无边框',
        scaleFit: '严格匹配',
        access: '允许脚本访问',
        accessAlways: '总是',
        accessSameDomain: '同域',
        accessNever: '从不',
        alignAbsBottom: '绝对底部',
        alignAbsMiddle: '绝对居中',
        alignBaseline: '基线',
        alignTextTop: '文本上方',
        quality: '质量',
        qualityBest: '最好',
        qualityHigh: '高',
        qualityAutoHigh: '高(自动)',
        qualityMedium: '中(自动)',
        qualityAutoLow: '低(自动)',
        qualityLow: '低',
        windowModeWindow: '窗体',
        windowModeOpaque: '不透明',
        windowModeTransparent: '透明',
        windowMode: '窗体模式',
        flashvars: 'Flash 变量',
        bgcolor: '背景颜色',
        hSpace: '水平间距',
        vSpace: '垂直间距',
        validateSrc: '请输入源文件地址',
        validateHSpace: '水平间距必须为数字格式',
        validateVSpace: '垂直间距必须为数字格式'
    },

    // Speller Pages Dialog
    spellCheck: {
        toolbar: '拼写检查',
        title: '拼写检查',
        notAvailable: '抱歉, 服务目前暂不可用',
        errorLoading: '加载应该服务主机时出错: %s.',
        notInDic: '没有在字典里',
        changeTo: '更改为',
        btnIgnore: '忽略',
        btnIgnoreAll: '全部忽略',
        btnReplace: '替换',
        btnReplaceAll: '全部替换',
        btnUndo: '撤消',
        noSuggestions: '- 没有建议 -',
        progress: '正在进行拼写检查...',
        noMispell: '拼写检查完成: 没有发现拼写错误',
        noChanges: '拼写检查完成: 没有更改任何单词',
        oneChange: '拼写检查完成: 更改了一个单词',
        manyChanges: '拼写检查完成: 更改了 %1 个单词',
        ieSpellDownload: '拼写检查插件还没安装, 你是否想现在就下载?'
    },

    smiley: {
        toolbar: '表情符',
        title: '插入表情图标',
        options: '表情图标选项'
    },

    elementsPath: {
        eleLabel: '元素路径',
        eleTitle: '%1 元素'
    },

    numberedlist: '编号列表',
    bulletedlist: '项目列表',
    indent: '增加缩进量',
    outdent: '减少缩进量',

    justify: {
        left: '左对齐',
        center: '居中',
        right: '右对齐',
        block: '两端对齐'
    },

    blockquote: '块引用',

    clipboard: {
        title: '粘贴',
        cutError: '您的浏览器安全设置不允许编辑器自动执行剪切操作, 请使用键盘快捷键(Ctrl/Cmd+X)来完成',
        copyError: '您的浏览器安全设置不允许编辑器自动执行复制操作, 请使用键盘快捷键(Ctrl/Cmd+C)来完成',
        pasteMsg: '请使用键盘快捷键(<STRONG>Ctrl/Cmd+V</STRONG>)把内容粘贴到下面的方框里，再按 <STRONG>确定</STRONG>',
        securityMsg: '因为你的浏览器的安全设置原因, 本编辑器不能直接访问你的剪贴板内容, 你需要在本窗口重新粘贴一次',
        pasteArea: '粘贴区域'
    },

    pastefromword: {
        confirmCleanup: '您要粘贴的内容好像是来自 MS Word, 是否要清除 MS Word 格式后再粘贴?',
        toolbar: '从 MS Word 粘贴',
        title: '从 MS Word 粘贴',
        error: '由于内部错误无法清理要粘贴的数据'
    },

    pasteText: {
        button: '粘贴为无格式文本',
        title: '粘贴为无格式文本'
    },

    templates: {
        button: '模板',
        title: '内容模板',
        options: '模板选项',
        insertOption: '替换当前内容',
        selectPromptMsg: '请选择编辑器内容模板:',
        emptyListMsg: '(没有模板)'
    },

    showBlocks: '显示区块',

    stylesCombo: {
        label: '样式',
        panelTitle: '样式',
        panelTitle1: '块级元素样式',
        panelTitle2: '内联元素样式',
        panelTitle3: '对象元素样式'
    },

    format: {
        label: '格式',
        panelTitle: '格式',

        tag_p: '普通',
        tag_pre: '已编排格式',
        tag_address: '地址',
        tag_h1: '标题 1',
        tag_h2: '标题 2',
        tag_h3: '标题 3',
        tag_h4: '标题 4',
        tag_h5: '标题 5',
        tag_h6: '标题 6',
        tag_div: '段落(DIV)'
    },

    div: {
        title: '创建 DIV 容器',
        toolbar: '创建 DIV 容器',
        cssClassInputLabel: '样式类名称',
        styleSelectLabel: '样式',
        IdInputLabel: 'ID',
        languageCodeInputLabel: '语言代码',
        inlineStyleInputLabel: '行内样式',
        advisoryTitleInputLabel: '标题',
        langDirLabel: '语言方向',
        langDirLTRLabel: '从左到右 (LTR)',
        langDirRTLLabel: '从右到左 (RTL)',
        edit: '编辑 DIV',
        remove: '移除 DIV'
    },

    iframe: {
        title: 'IFrame 属性',
        toolbar: 'IFrame',
        noUrl: '请输入框架的 URL',
        scrolling: '允许滚动条',
        border: '显示框架边框'
    },

    font: {
        label: '字体',
        voiceLabel: '字体',
        panelTitle: '字体'
    },

    fontSize: {
        label: '大小',
        voiceLabel: '文字大小',
        panelTitle: '大小'
    },

    colorButton: {
        textColorTitle: '文本颜色',
        bgColorTitle: '背景颜色',
        panelTitle: '颜色',
        auto: '自动',
        more: '其它颜色...'
    },

    colors: {
        '000': '黑',
        '800000': '褐红',
        '8B4513': '深褐',
        '2F4F4F': '墨绿',
        '008080': '绿松石',
        '000080': '海军蓝',
        '4B0082': '靛蓝',
        '696969': '暗灰',
        'B22222': '砖红',
        'A52A2A': '褐',
        'DAA520': '金黄',
        '006400': '深绿',
        '40E0D0': '蓝绿',
        '0000CD': '中蓝',
        '800080': '紫',
        '808080': '灰',
        'F00': '红',
        'FF8C00': '深橙',
        'FFD700': '金',
        '008000': '绿',
        '0FF': '青',
        '00F': '蓝',
        'EE82EE': '紫罗兰',
        'A9A9A9': '深灰',
        'FFA07A': '亮橙',
        'FFA500': '橙',
        'FFFF00': '黄',
        '00FF00': '水绿',
        'AFEEEE': '粉蓝',
        'ADD8E6': '亮蓝',
        'DDA0DD': '梅红',
        'D3D3D3': '淡灰',
        'FFF0F5': '淡紫红',
        'FAEBD7': '古董白',
        'FFFFE0': '淡黄',
        'F0FFF0': '蜜白',
        'F0FFFF': '天蓝',
        'F0F8FF': '淡蓝',
        'E6E6FA': '淡紫',
        'FFF': '白'
    },

    scayt: {
        title: '即时拼写检查',
        opera_title: '不支持 Opera 浏览器',
        enable: '启用即时拼写检查',
        disable: '禁用即时拼写检查',
        about: '关于即时拼写检查',
        toggle: '暂停/启用即时拼写检查',
        options: '选项',
        langs: '语言',
        moreSuggestions: '更多拼写建议',
        ignore: '忽略',
        ignoreAll: '全部忽略',
        addWord: '添加单词',
        emptyDic: '字典名不应为空.',

        optionsTab: '选项',
        allCaps: '忽略所有大写单词',
        ignoreDomainNames: '忽略域名',
        mixedCase: '忽略大小写混合的单词',
        mixedWithDigits: '忽略带数字的单词',

        languagesTab: '语言',

        dictionariesTab: '字典',
        dic_field_name: '字典名称',
        dic_create: '创建',
        dic_restore: '还原',
        dic_delete: '删除',
        dic_rename: '重命名',
        dic_info: '一开始用户词典储存在 Cookie 中, 但是 Cookies 的容量是有限的, 当用户词典增长到超出 Cookie 限制时就无法再储存了, 这时您可以将词典储存到我们的服务器上. 要把您的个人词典到储存到我们的服务器上的话, 需要为您的词典指定一个名称, 如果您在我们的服务器上已经有储存有一个词典, 请输入词典名称并按还原按钮.',

        aboutTab: '关于'
    },

    about: {
        title: '关于CKEditor',
        dlgTitle: '关于CKEditor',
        help: '请访问 $1 以获取帮助.',
        userGuide: 'CKEditor 用户向导',
        moreInfo: '访问我们的网站以获取更多关于协议的信息',
        copy: 'Copyright &copy; $1. 版权所有。'
    },

    maximize: '全屏',
    minimize: '最小化',

    fakeobjects: {
        anchor: '锚点',
        flash: 'Flash 动画',
        iframe: 'IFrame',
        hiddenfield: '隐藏域',
        unknown: '未知对象'
    },

    resize: '拖拽以改变尺寸',

    colordialog: {
        title: '选择颜色',
        options: '颜色选项',
        highlight: '高亮',
        selected: '选择颜色',
        clear: '清除'
    },

    toolbarCollapse: '折叠工具栏',
    toolbarExpand: '展开工具栏',

    toolbarGroups: {
        document: '文档',
        clipboard: '剪贴板/撤销',
        editing: '编辑',
        forms: '表单',
        basicstyles: '基本格式',
        paragraph: '段落',
        links: '链接',
        insert: '插入',
        styles: '样式',
        colors: '颜色',
        tools: '工具'
    },

    bidi: {
        ltr: '文字方向为从左至右',
        rtl: '文字方向为从右至左'
    },

    docprops: {
        label: '页面属性',
        title: '页面属性',
        design: '设计',
        meta: 'Meta 数据',
        chooseColor: '选择',
        other: '<其他>',
        docTitle: '页面标题',
        charset: '字符编码',
        charsetOther: '其它字符编码',
        charsetASCII: 'ASCII',
        charsetCE: '中欧',
        charsetCT: '繁体中文 (Big5)',
        charsetCR: '西里尔文',
        charsetGR: '希腊文',
        charsetJP: '日文',
        charsetKR: '韩文',
        charsetTR: '土耳其文',
        charsetUN: 'Unicode (UTF-8)',
        charsetWE: '西欧',
        docType: '文档类型',
        docTypeOther: '其它文档类型',
        xhtmlDec: '包含 XHTML 声明',
        bgColor: '背景颜色',
        bgImage: '背景图像',
        bgFixed: '不滚动背景图像',
        txtColor: '文本颜色',
        margin: '页面边距',
        marginTop: '上',
        marginLeft: '左',
        marginRight: '右',
        marginBottom: '下',
        metaKeywords: '页面索引关键字 (用半角逗号[,]分隔)',
        metaDescription: '页面说明',
        metaAuthor: '作者',
        metaCopyright: '版权',
        previewHtml: '<p>这是一些<strong>演示用文字</strong>。你当前正在使用<a href="javascript:void(0)">CKEditor</a>。</p>'
    }
};
