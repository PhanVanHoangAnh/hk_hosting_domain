var SourceDataManager2 = class {
    constructor(options) {
        this.container = options.container;
        this.initData = window.initSourceData;
        this.events();
    }

    getSubChannels() {
        const subChannels = [];

        this.initData.forEach(source => {
            const channels = source.values;

            channels.forEach(channel => {
                const subs = channel.values;
                
                subs.forEach(subChannel => {
                    subChannels.push(subChannel);
                })
            })
        });

        return subChannels;
    }

    loadSubChannels() {

    }

    getAutoLoadForm() {
        // return this.container().find()
    }

    events() {
    }
}