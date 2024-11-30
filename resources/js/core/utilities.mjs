function when(condition, trueValue, defaultValue =  null){
    if (condition){
        return is(typeof trueValue, "function") ?
        trueValue() : trueValue;
    }else{
        if (defaultValue){
            return !isNull(defaultValue) && is(typeof defaultValue, "function")
            ? defaultValue() : defaultValue;
        }
        return null;
    }
}
function taskStatusSeverity(status){
    let severity = null;
    switch(status){
        case "WAT" :
            severity = "warning";
            break;
        case "PRO" :
            severity = "primary";
            break;
        case "CON" :
            severity = "success";
            break;
        default : severity = "secondary";
    }
    return severity;
}
function prioritySeverity(priority){
    if(priority === "ALT")  return "danger";
    if (priority === "MED") return "warning";
    return "secondary";
}
const isNull = (arg) => arg == null;
const isNullOrWhiteSpace = (arg) => arg == null || arg == "";
const is = (arg, value) => arg == value;

export {
    isNull,
    isNullOrWhiteSpace,
    taskStatusSeverity,
    prioritySeverity,
    when,
    is
}

