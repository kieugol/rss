/**
 * Using for homepage displays RSS data
 */
var HandlingRss = function() {
    var Rss = {
        modal: {
            self : $('#modal-detail'),
            title: $('#modal-detail .modal-title'),
            body : $("#modal-detail .modal-body")
        },
        showDetail: $(".show-detail"),

        initToolTip: function () {
            $('[data-toggle="tooltip"]').tooltip();
        },
        showDetailHiddenContent: function () {
            var objSelf = this;
            $(objSelf.showDetail).click(function() {
                var html = objSelf.decodeHtmlEntity($(this).next().html());
                objSelf.modal.title.text($(this).attr('name'));
                objSelf.modal.body.html(null).append(html);
                objSelf.modal.self.modal('toggle');
                return false;
            });
        },
        decodeHtmlEntity: function (stringHTML) {
            var e = document.createElement('div');
            e.innerHTML = stringHTML;
            return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
        }
    };

    return {
        init: function () {
            Rss.initToolTip();
            Rss.showDetailHiddenContent();
        }
    };
};
