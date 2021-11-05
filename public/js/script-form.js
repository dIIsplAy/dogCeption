
        const addFormToCollection = (e) => {
            const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.listSelector);
            const item = document.createElement('div');

            let proto = JSON.parse(JSON.stringify({text: collectionHolder.dataset.prototype}));

            item.innerHTML = 
                proto.text
                .replace(
                    /__name__/g,
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
