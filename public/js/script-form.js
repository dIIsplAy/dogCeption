
        const addFormToCollection = (e) => {
            const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.listSelector);
            const item = document.createElement('div');
            const pattern = collectionHolder.dataset.protoPattern;
            const regex = new RegExp(pattern,"g");

            item.innerHTML = collectionHolder
                .dataset
                .prototype
                .replace(
                    regex,
                    collectionHolder.dataset.widgetCounter
                );

            collectionHolder.appendChild(item);
            collectionHolder.dataset.widgetCounter++;
            document
                .querySelectorAll('.add')
                .forEach(btn => {
                    btn.removeEventListener('click', addFormToCollection);
                    btn.addEventListener("click", addFormToCollection);
                });
        }
        document
            .querySelectorAll('.add')
            .forEach(btn => btn.addEventListener("click", addFormToCollection));
