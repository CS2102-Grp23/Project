import EventEmitter from 'events';

class ProjectRepository extends EventEmitter {
  get uid() {
    this.uid = '';
    //return firebase.auth().currentUser.uid;
  }
  get projectsRef() {
    return this.ref.child(`users/${this.uid}/projects`);
  }
  constructor() {
    super();
   // this.ref = firebase.database().ref('projects');
  }
  attachFirebaseListeners() {
    this.projectsRef.on('child_added', this.onAdded, this);
    this.projectsRef.on('child_removed', this.onRemoved, this);
    this.projectsRef.on('child_changed', this.onChanged, this);
  }
  detachFirebaseListeners() {
    this.projectsRef.off('child_added', this.onAdded, this);
    this.projectsRef.off('child_removed', this.onRemoved, this);
    this.projectsRef.off('child_changed', this.onChanged, this);
  }
  onAdded(snapshot) {
    const project = this.snapshotToProject(snapshot);
    this.emit('added', project);
  }
  onRemoved(oldSnapshot) {
    const project = this.snapshotToProject(oldSnapshot);
    this.emit('removed', project);
  }
  onChanged(snapshot) {
    const project = this.snapshotToProject(snapshot);
    this.emit('changed', project);
  }
  snapshotToProject(snapshot) {
    const key = snapshot.key;
    const project = snapshot.val();
    project.key = key;
    return project;
  }
  create({ title = '', content = '' }, onComplete) {
    this.projectsRef.push({ title, content }, onComplete);
  }
  update({ key, title = '', content = '' }, onComplete) {
    this.projectsRef.child(key).update({ title, content }, onComplete);
  }
  remove({ key }, onComplete) {
    this.projectsRef.child(key).remove(onComplete);
  }
  findIndex(projects, key) {
    return projects.findIndex(project => project.key === key);
  }
  find(projects, key) {
    return projects.find(project => project.key === key);
  }
}

export default new ProjectRepository();