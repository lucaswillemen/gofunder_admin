class MyUploadAdapter {
    constructor( loader ) {
        this.loader = loader;
    }
    upload() {
        server.onUploadProgress( data => {
            loader.uploadTotal = data.total;
            loader.uploaded = data.uploaded;
        });
        return loader.file
            .then( file => server.upload( file ) );
    }
    abort() {
        server.abortUpload();
    }
}