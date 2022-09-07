function Todo(props) {
    function deleteH() {
        console.log(props.id);
    }
    return (
        <div className='card'>
            <div className='card-header'>
                {props.text}
            </div>
            <div className='card-body'>
                This dte card body
            </div>
            <div className='card-footer'>
                <button className='btn btn-danger' onClick={deleteH}>
                {props.deleteText}
                </button>
            </div>
        </div>
    );
}

export default Todo;