const DEFAULT_LIFICYCLE_STAGE = "Chưa có dữ liệu!";

class SourceDataManager {
    #data = contactSources;
    #sourceTypes;
    #channels;
    #subChannels;
    #currSourceType;
    #currChannel;

    constructor(options) {
        this.container = options.container;
        this.selectLeadStatus = options.selectLeadStatus;
        this.leadStatusManager = new LeadStatusManager({
            sourceDataManager: this
        });

        if (typeof options.selectedSourceType != 'undefined') {
            this.selectedSourceType = options.selectedSourceType;
        }

        if (typeof options.selectedChannel != 'undefined') {
            this.selectedChannel = options.selectedChannel;
        }

        if (typeof options.selectedSubChannel != 'undefined') {
            this.selectedSubChannel = options.selectedSubChannel;
        }

        this.dutiesAfterInit();
    };

    getSourceTypeSelect() {
        if (this.container) {
            return this.container.querySelector('#source-type-select');
        };
    };

    getSourceTypeSelectValue() {
        if (this.getSourceTypeSelect()) {
            return this.getSourceTypeSelect().value;
        };
    };

    getChannelSelect() {
        if (this.container) {
            return this.container.querySelector('#channel-select');
        };
    };

    getChannelSelectValue() {
        if (this.getChannelSelect()) {
            return this.getChannelSelect().value;
        };
    };

    getSubChannelSelect() {
        if (this.container) {
            return this.container.querySelector('#sub-channel-select');
        };
    };

    getSubChannelSelectValue() {
        if (this.getSubChannelSelect()) {
            return this.getSubChannelSelect().value;
        };
    };

    getSourceDataForm() {
        if (this.container) {
            return this.container.querySelector('#source-data-form');
        };
    };
   
    showSourceDataform() {
        if (this.getSourceDataForm()) {
            this.getSourceDataForm().classList.remove('d-none');
        };
    };

    hideSourceDataForm() {
        if (this.getSourceDataForm()) {
            this.getSourceDataForm().classList.add('d-none');
        };
    };
    offSourceData() {
        this.hideSourceDataForm();
        this.disableSourceData();
    };

    onSourceData() {
        this.showSourceDataform();
        this.enableSourceData();
    };

    disableSourceData() {
        if (this.getSourceDataItems()) {
            const items = this.getSourceDataItems();
    
            if (items && items.length > 0) {
                items.forEach(item => {
                    item.setAttribute('disabled', '');
                });
            };
        };
    };

    enableSourceData() {
        if (this.getSourceDataItems()) {
            const items = this.getSourceDataItems();
    
            if (items && items.length > 0) {
                items.forEach(item => {
                    item.removeAttribute('disabled');
                });
            };
        };
    };

    getSourceDataSubChannel() {
        if (this.container) {
            return this.container.querySelector('#source-data-sub-channel');
        };
    };

    showSourceDataSubChannel() {
        if (this.getSourceDataSubChannel()) {
            this.getSourceDataSubChannel().classList.remove('d-none');
        };
    };

    hideSourceDataSubChannel() {
        if (this.getSourceDataSubChannel()) {
            this.getSourceDataSubChannel().classList.add('d-none');
        };
    };

    offSourceDataSubChannel() {
        this.hideSourceDataSubChannel();
    };

    onSourceDataSubChannel() {
        this.showSourceDataSubChannel();
    };

    getSourceDataItems() {
        if (this.container) {
            return this.container.querySelectorAll('[data-source="source-item"]');
        };
    }; 

    loadSourceType() {
        this.setSourceType();
        this.insertSourceTypeData();
    };

    setSourceType() {
        this.#sourceTypes = this.#data;
    };

    insertSourceTypeData() {
        let content = `<option value="">Chọn</option>`;

        if (Array.isArray(this.#sourceTypes) && this.#sourceTypes.length > 0) {
            this.#sourceTypes.forEach(sourceType => {
                let value;
                let key;
                let isSelected = '';

                if (typeof sourceType === 'string') {
                    value = sourceType;
                    key = sourceType;
                } else if (typeof sourceType === 'object' && !Array.isArray(sourceType)) {
                    value = sourceType['name'];
                    key = sourceType['itemKey'];
                } else {
                    value = '';
                };

                if (this.selectedSourceType && this.selectedSourceType.toLowerCase() && this.selectedSourceType.toLowerCase() == sourceType.name.toLowerCase()) {
                    isSelected = 'selected';
                }

                content += `<option ${isSelected} value="${key}">${value}</option>`;
            });
        };

        if (this.getSourceTypeSelect()) {
            this.getSourceTypeSelect().innerHTML = content;
        };
    };

    setCurrSourceType(currSourceType) {
        this.#currSourceType = currSourceType;
        this.setChannel();
        this.setSubChannel();
    };

    setChannel() {
        let channels = this.#getChilds(this.#sourceTypes, this.#currSourceType);
        let channelValues = this.#getChildKeys(channels);
        this.#channels = channelValues;
        this.insertChannelData();
    };

    insertChannelData() {
        let content = `<option value="">Chọn</option>`;

        if (Array.isArray(this.#channels) && this.#channels.length > 0) {
            this.#channels.forEach(channel => {
                let isSelected = '';
                let value;
                let key;

                if (typeof channel === 'string') {
                    value = channel;
                    key = channel;
                } else if (typeof channel === 'object' && !Array.isArray(channel)) {
                    value = channel['name'];
                    key = channel['itemKey'];
                } else {
                    value = '';
                };

                if (this.selectedChannel && this.selectedChannel.toLowerCase() && this.selectedChannel.toLowerCase() == channel.name.toLowerCase()) {
                    isSelected = 'selected';
                }

                content += `<option ${isSelected} value="${key}">${value}</option>`;
            });
        };

        if (this.getChannelSelect()) {
            this.getChannelSelect().innerHTML = content;
        };
    };

    setCurrChannel(currChannel) {
        this.#currChannel = currChannel;
        this.setSubChannel();
    };

    setSubChannel() {
        let subChannels = this.#getChilds(this.#channels, this.#currChannel);
        let subChannelValues = this.#getChildKeys(subChannels);
        this.#subChannels = subChannelValues;
        this.insertSubChannelData();
    };

    insertSubChannelData() {
        let content = `<option value="">Chọn</option>`;

        if (Array.isArray(this.#subChannels) && this.#subChannels.length > 0) {
            this.#subChannels.forEach(subChannel => {
                let isSelected = '';
                let value;
                let key;

                if (typeof subChannel === 'string') {
                    value = subChannel;
                    key = subChannel;
                } else if (typeof subChannel === 'object' && !Array.isArray(subChannel)) {
                    value = subChannel['name'];
                    key = subChannel['itemKey'];
                } else {
                    value = '';
                };

                if (this.selectedSubChannel && this.selectedSubChannel && this.selectedSubChannel.toLowerCase() && this.selectedSubChannel.toLowerCase() == value.toLowerCase()) {
                    isSelected = 'selected';
                }

                content += `<option ${isSelected} value="${key}">${value}</option>`;
            });
        };

        if (this.getSubChannelSelect()) {
            this.getSubChannelSelect().innerHTML = content;
        };
    };

    #getChilds(parent, childKey) {
        let childsArray = null;

        if (parent && childKey) {
            parent.forEach(child => {
                if (child) {
                    if (typeof child === 'string') {
                        if (child === childKey) {
                            childsArray = child;
                        }
                    } else if (typeof child === 'object' && !Array.isArray(child)) {
                        if (child['itemKey'].trim() === childKey.trim()) {
                            childsArray = child.values;
                        }
                    } else {
                        childsArray = null;
                    };
                }
            });
        };

        return childsArray; 
    };

    #getChildKeys(childs) {
        let childKeys = [];

        if (Array.isArray(childs)) {
            childs.forEach(child => {
                childKeys.push(child);
            });
        } else {
            childKeys = null;
        };

        return childKeys;
    };

    checkAndLoadCurrValueAfterInit() {
        let currSourceTypeSelectValue = this.getSourceTypeSelectValue();

        if (currSourceTypeSelectValue === 'offline' || currSourceTypeSelectValue === '' || !currSourceTypeSelectValue) {
            this.offSourceData();
        } else {
            this.onSourceData();
        };
    };

    dutiesAfterInit() {
        this.checkAndLoadCurrValueAfterInit();
        this.loadSourceType();
        this.events();
    };

    events() {
        if (this.getSourceTypeSelect()) {
            $(this.getSourceTypeSelect()).on('change', e => {
                e.preventDefault();

                let currSourceTypeSelectValue = this.getSourceTypeSelectValue();
                
                this.setCurrSourceType(currSourceTypeSelectValue);
    
                if (currSourceTypeSelectValue === 'digital' || currSourceTypeSelectValue === '' || !currSourceTypeSelectValue) {
                    
                    this.onSourceData();
                } else {
                    this.offSourceData();
                };

                if (currSourceTypeSelectValue === 'other') {
                    this.offSourceDataSubChannel();
                } else {
                    this.onSourceDataSubChannel();
                };
            });
        };

        if (this.getChannelSelect()) {
            $(this.getChannelSelect()).on('change', e => {
                e.preventDefault();
                this.setCurrChannel(this.getChannelSelectValue());
            });
        };
    };
};

class LeadStatusManager {
    #data = leadStatusValues;
    #currLifeCycleStage = DEFAULT_LIFICYCLE_STAGE;
    #leadStatuses = [];

    constructor(options) {
        this.sourceDataManager = options.sourceDataManager;

        this.insertLeadStatusData();
        this.events();
    };

    getLeadStatusSelect() {
        if (this.sourceDataManager.container) {
            return this.sourceDataManager.container.querySelector('[name="lead_status"]');
        };
    };

    getLifeCycleStageForm() {
        if (this.sourceDataManager.container) {
            return this.sourceDataManager.container.querySelector('[name="lifecycle_stage"]');
        };
    };

    getLeadStatuses() {
        let tmpArr = [];

        for(let [key, value] of Object.entries(this.#data)) {
            tmpArr.push(key);
        };

        const seen = {};

        for(let i = 0; i < tmpArr.length; ++i) {
            let currValue = tmpArr[i];

            if (!seen[currValue]) {
                this.#leadStatuses.push(currValue);
                seen[currValue] = true;
            };
        };

        return this.#leadStatuses;
    };

    insertLeadStatusData() {
        let content = `<option value="">Chọn</option>`;
        const leadStatuses = this.getLeadStatuses();

        if (leadStatuses) {
            leadStatuses.forEach(leadStatus => {
                let isSelected = '';
                if (this.sourceDataManager.selectLeadStatus === leadStatus) { 
                    isSelected = 'selected';
                }

                content += `<option ${isSelected} value="${leadStatus}">${leadStatus}</option>`;
            });
        };

        if (this.getLeadStatusSelect()) {
            this.getLeadStatusSelect().innerHTML = content;
        };
    };

    getCurrLifeCycleStage(currLeadStatus) {
        for(let [key, value] of Object.entries(this.#data)) {
            if (currLeadStatus === key) {
                this.#currLifeCycleStage = value;
                return;
            };
        };

        this.#currLifeCycleStage = DEFAULT_LIFICYCLE_STAGE;
    };

    loadCurrLifeCycleStage() {
        this.getLifeCycleStageForm().value = this.#currLifeCycleStage;
    };

    events() {
        let _this = this;
        $(this.getLeadStatusSelect()).on('change', function(e) {
            e.preventDefault();
            _this.getCurrLifeCycleStage(this.value);
            _this.loadCurrLifeCycleStage();
        });
    };
}